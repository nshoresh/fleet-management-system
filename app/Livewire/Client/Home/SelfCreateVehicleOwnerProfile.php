<?php

namespace App\Livewire\Client\Home;

use App\Jobs\BusinessRegistrationNotificationJob;
use App\Models\Business;
use App\Models\VehicleOwner;
use App\Models\VehicleOwnerType;
use App\Services\VerificationCodeService;
use App\Mail\VerificationCodeMail;
use App\Mail\BusinessRegistrationSubmitted;
use App\Mail\BusinessRegistrationReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Node\Query;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

class SelfCreateVehicleOwnerProfile extends Component
{
    use WithFileUploads;

    public const TOTAL_STEPS = 4;
    public const VERIFICATION_CODE_LENGTH = 6;
    public const VERIFICATION_CODE_EXPIRY_MINUTES = 15;
    public const MAX_FILE_SIZE = 2048; // KB
    public const ALLOWED_FILE_TYPES = 'pdf,jpg,jpeg,png';

    public int $currentStep;
    public $totalSteps = self::TOTAL_STEPS;

    // Step 1: Owner Information
    #[Validate('required|string|max:255|min:2')]
    public $name = '';

    #[Validate('required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/')]
    public $contact_number = '';

    #[Validate('required|email|max:255|unique:vehicle_owners,email')]
    public $email = '';

    #[Validate('required|string|max:1000|min:10')]
    public $address = '';

    #[Validate('required|exists:vehicle_owner_types,id')]
    public $vehicle_owner_type_id = '';

    #[Validate('required|string|max:50|min:5')]
    public $id_number = '';

    #[Validate('required|in:national_id,passport,drivers_license,business_id')]
    public $id_type = 'national_id';


    // Step 2: Business Information (conditional based on owner type)
    #[Validate('nullable|string|max:255|min:2')]
    public $business_name = '';

    #[Validate('nullable|string|max:255')]
    public $business_type = '';

    #[Validate('nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/')]
    public $business_phone = '';

    #[Validate('nullable|email|max:255')]
    public $business_email = '';

    #[Validate('nullable|string|max:1000')]
    public $business_address = '';

    #[Validate('nullable|string|max:255')]
    public $business_registration_number = '';

    #[Validate('nullable|date|before_or_equal:today')]
    public $business_registration_date = '';

    #[Validate('nullable|string|max:100')]
    public $business_tax_id = '';

    #[Validate('nullable|url|max:255')]
    public $business_website = '';

    #[Validate('nullable|string|max:255')]
    public $business_contact_person = '';

    #[Validate('nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/')]
    public $business_contact_number = '';

    #[Validate('nullable|string|max:255')]
    public $position = '';

    // Step 3: Document Uploads
    #[Validate('required|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE)]
    public $id_document;

    #[Validate('nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE)]
    public $business_registration_certificate;

    #[Validate('nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE)]
    public $business_logo;

    #[Validate('nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE)]
    public $tax_clearance;

    #[Validate('nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE)]
    public $proof_of_address;

    // Step 4: Verification & Submission
    public $terms_accepted = false;
    public $privacy_accepted = false;
    public $verification_code = '';
    public $verification_code_input = '';
    public $verification_code_sent = false;
    public $verification_code_sent_at = null;
    public $can_resend_code = true;
    public $resend_cooldown = 0;
    // Status & Results
    public $is_verified = false;
    public $submission_complete = false;
    public $vehicle_owner_id = null;
    public $is_loading = false;

    // Data Collections
    public $vehicle_owner_types = [];
    public $business_types = [];
    public $is_business_owner = false;

    // Configuration Arrays
    public $id_types = [
        'national_id' => 'National ID',
        'passport' => 'Passport',
        'drivers_license' => 'Driver\'s License',
        'business_id' => 'Business ID',
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'resetVerification' => 'resetVerificationState',
        'registration-completed' => 'loadDashboard'
    ];

    protected $queryString = [
        'currentStep' => ['except', 1]
    ];


    public function mount()
    {
        $this->totalSteps = self::TOTAL_STEPS;
        $this->currentStep = 1;
        $this->email = auth()->user()->email;
        $this->name = auth()->user()->name;

        $this->contact_number = auth()->user()->phone;
        $this->loadInitialData();
        $this->setDefaultValues();
    }

    private function loadInitialData()
    {
        try {
            $this->vehicle_owner_types = VehicleOwnerType::all();
            $this->business_types = $this->getBusinessTypes();
        } catch (\Exception $e) {
            Log::error('Failed to load initial data: ' . $e->getMessage());
            session()->flash('error', 'Failed to load form data. Please refresh the page.');
        }
    }

    public function loadDashboard()
    {
        return redirect()->route('dashboard')->with('success', 'Business account registered successfully');
    }
    private function setDefaultValues()
    {
        $this->business_registration_date = $this->business_registration_date ?: Carbon::now()->format('Y-m-d');
    }

    private function getBusinessTypes()
    {
        return [
            'corporation' => 'Corporation',
            'llc' => 'Limited Liability Company (LLC)',
            'partnership' => 'Partnership',
            'sole_proprietorship' => 'Sole Proprietorship',
            'nonprofit' => 'Non-Profit Organization',
            'cooperative' => 'Cooperative',
            'other' => 'Other'
        ];
    }

    public function updatedVehicleOwnerTypeId()
    {

        $ownerType = $this->vehicle_owner_types->find($this->vehicle_owner_type_id);
        $this->is_business_owner = $ownerType && in_array(strtolower($ownerType->name), ['company', 'business', 'corporation', 'organization']);
    }

    public function render()
    {
        return view(
            'livewire.client.home.self-create-vehicle-owner-profile',
            [
                'totalSteps' => $this->totalSteps,
                'businessTypes' => $this->business_types,
                'stepProgress' => $this->getStepProgress(),
                'canProceed' => $this->canProceedToNextStep(),
                'currentStep' => $this->currentStep,
                'step_title' => $this->getStepTitle($this->currentStep),
                'verificationTimeRemaining' => $this->getVerificationTimeRemaining(),
                'isBusiness' => $this->is_business_owner
            ]
        );
    }

    #[Computed]
    public function getStepProgress()
    {
        return round(($this->currentStep / $this->totalSteps) * 100);
    }

    public function nextStep()
    {
        if ($this->is_loading) return;

        $this->is_loading = true;

        try {
            $this->validate($this->getValidationRulesForStep($this->currentStep));

            if ($this->currentStep < $this->totalSteps) {
                $this->currentStep++;
                // $this->dispatch('step-changed', step: $this->currentStep);
            }
        } catch (\Throwable $e) {
            Log::error('There was an error ' . $e->getMessage());
            session()->flash('error', 'There was an error ' . $e->getMessage());
        } finally {
            $this->is_loading = false;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps && $step <= $this->getMaxAccessibleStep()) {
            $this->currentStep = $step;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    private function getMaxAccessibleStep()
    {
        for ($i = 1; $i <= $this->totalSteps; $i++) {
            if (!$this->isStepCompleted($i)) {
                return $i;
            }
        }
        return $this->totalSteps;
    }

    private function validateCurrentStep()
    {
        $validationRules = $this->getValidationRulesForStep($this->currentStep);
        $this->validate($validationRules);
    }

    private function getValidationRulesForStep($step)
    {
        $rules = [
            1 => $this->getBusinessValidationRules(),
            2 => $this->getBusinessOwnerValidationRules(),
            3 => $this->getDocumentsValidationRules(),
            4 => [
                'terms_accepted' => 'required|accepted',
                'privacy_accepted' => 'required|accepted',
            ]
        ];

        return $rules[$step] ?? [];
    }


    // Steps Validation functions
    private function getBusinessValidationRules()
    {
        return [
            'business_name' => 'required|string|max:255|min:2',
            'vehicle_owner_type_id' => 'required|integer',
            'business_phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'business_email' => 'required|email|max:255',
            'business_address' => 'nullable|string|max:1000',
            'business_registration_number' => 'required|string|max:255',
            'business_registration_date' => 'required|date|before_or_equal:today',
            'business_contact_person' => 'nullable|string|max:255',
            'business_contact_number' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
        ];
    }
    private function getBusinessOwnerValidationRules()
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'contact_number' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'email' => 'required|email|max:255|unique:vehicle_owners,email',
            'address' => 'required|string|max:121000|min:10',
            'id_number' => 'required|string',
            'id_type' => 'required|string',
            'position' => 'required|string|max:255|min:4'
        ];
    }
    private function getDocumentsValidationRules()
    {
        return [
            'id_document' => 'required|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE,
            'business_registration_certificate' => $this->is_business_owner ? 'required|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE : 'nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE,
            'business_logo' => 'nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE,
            'tax_clearance' => 'nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE,
            'proof_of_address' => 'nullable|file|mimes:' . self::ALLOWED_FILE_TYPES . '|max:' . self::MAX_FILE_SIZE,
        ];
    }


    public function sendVerificationCode()
    {
        if ($this->is_loading) return;

        $this->validate(['email' => 'required|email']);

        if (!$this->canResendVerificationCode()) {
            $this->addError('verification', 'Please wait before requesting another code.');
            return;
        }

        $this->is_loading = true;

        try {
            $this->verification_code = $this->generateVerificationCode();
            $this->verification_code_sent = true;
            $this->verification_code_sent_at = now();
            $this->can_resend_code = false;
            $this->startResendCooldown();

            // Send verification email
            Mail::to($this->email)->send(
                new VerificationCodeMail(
                    $this->verification_code,
                    $this->email,
                    self::VERIFICATION_CODE_EXPIRY_MINUTES
                )
            );

            session()->flash(
                'verification_message',
                'Verification code sent to ' . $this->email
            );
            $this->dispatch('verification-code-sent');
        } catch (\Exception $e) {
            Log::error('Failed to send verification code: ' . $e->getMessage(), [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
            session()->flash(
                'error',
                'Failed to send verification code. Please try again.'
            );
        } finally {
            $this->is_loading = false;
        }
    }

    private function generateVerificationCode()
    {
        return str_pad(random_int(0, 999999), self::VERIFICATION_CODE_LENGTH, '0', STR_PAD_LEFT);
    }

    private function canResendVerificationCode()
    {
        if (!$this->verification_code_sent_at) {
            return true;
        }

        return Carbon::parse($this->verification_code_sent_at)
            ->addMinutes(1)
            ->isPast();
    }

    private function startResendCooldown()
    {
        $this->resend_cooldown = 60; // 60 seconds
        $this->dispatch('start-resend-cooldown', seconds: $this->resend_cooldown);
    }

    public function verifyCode()
    {
        if ($this->is_loading) return;

        $this->validate(['verification_code_input' => 'required|string|size:' . self::VERIFICATION_CODE_LENGTH]);

        if ($this->isVerificationCodeExpired()) {
            $this->addError('verification_code_input', 'Verification code has expired. Please request a new one.');
            $this->resetVerificationState();
            return;
        }

        if ($this->verification_code === $this->verification_code_input) {
            $this->is_verified = true;
            session()->flash(
                'verification_success',
                'Email verified successfully!'
            );
            $this->dispatch('email-verified');
        } else {
            $this->addError('verification_code_input', 'Invalid verification code. Please try again.');
        }
    }

    private function isVerificationCodeExpired()
    {
        if (!$this->verification_code_sent_at) {
            return true;
        }

        return Carbon::parse($this->verification_code_sent_at)
            ->addMinutes(self::VERIFICATION_CODE_EXPIRY_MINUTES)
            ->isPast();
    }

    public function resetVerificationState()
    {
        $this->verification_code = '';
        $this->verification_code_input = '';
        $this->verification_code_sent = false;
        $this->verification_code_sent_at = null;
        $this->is_verified = false;
        $this->can_resend_code = true;
        $this->resend_cooldown = 0;
    }

    private function getVerificationTimeRemaining()
    {
        if (!$this->verification_code_sent_at) {
            return 0;
        }

        $expiryTime = Carbon::parse($this->verification_code_sent_at)
            ->addMinutes(self::VERIFICATION_CODE_EXPIRY_MINUTES);

        return max(0, $expiryTime->diffInMinutes(now()));
    }

    public function submitRegistration()
    {
        if ($this->is_loading) return;
        $this->validate([
            'terms_accepted' => 'required|accepted',
            'privacy_accepted' => 'required|accepted',
        ]);
        Log::info("REgistration Submited");
        $this->is_loading = true;

        DB::beginTransaction();

        try {
            // Store uploaded files
            $documentPaths = $this->storeUploadedFiles();
            $vehicleOwner = $this->createVehicleOwnerRecord();
            if ($vehicleOwner) {
                Log::info(json_encode($vehicleOwner));
            }
            $this->sendNotificationEmails($vehicleOwner);
            DB::commit();
            $this->vehicle_owner_id = $vehicleOwner->id;
            $this->submission_complete = true;
            auth()->user()->update(
                ['vehicle_owner_id' => $this->vehicle_owner_id]
            );

            session()->flash(
                'success',
                'Vehicle owner registration submitted successfully! You will receive a confirmation email shortly.'
            );
            $this->dispatch('registration-completed');
        } catch (\Exception $e) {
            DB::rollBack();
            // Clean up uploaded files on error
            $this->cleanupUploadedFiles();
            Log::error('Vehicle Owner Registration Error: ' . $e->getMessage(), [
                'user_data' => $this->getLoggableUserData(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'An error occurred during registration. Please try again or contact support if the problem persists.');
        } finally {
            $this->is_loading = false;
        }
    }

    private function storeUploadedFiles()
    {
        $paths = [];

        if ($this->id_document) {
            $paths['id_document'] = $this->id_document->store('vehicle-owner-documents/identification', 'public');
        }

        if ($this->business_registration_certificate) {
            $paths['business_registration_certificate'] = $this->business_registration_certificate->store('vehicle-owner-documents/business', 'public');
        }

        if ($this->business_logo) {
            $paths['business_logo'] = $this->business_logo->store('vehicle-owner-documents/logos', 'public');
        }

        if ($this->tax_clearance) {
            $paths['tax_clearance'] = $this->tax_clearance->store('vehicle-owner-documents/tax', 'public');
        }

        if ($this->proof_of_address) {
            $paths['proof_of_address'] = $this->proof_of_address->store('vehicle-owner-documents/address', 'public');
        }

        return $paths;
    }

    private function createVehicleOwnerRecord()
    {
        return VehicleOwner::create([
            'name' => trim($this->name),
            'contact_number' => $this->contact_number,
            'email' => strtolower(trim($this->email)),
            'address' => trim($this->address),
            'vehicle_owner_type_id' => $this->vehicle_owner_type_id,
            'business_name' => $this->business_name,
            'business_phone' => $this->business_phone,
            'business_email' => $this->business_email,
            'business_address' => $this->business_address,
            'business_registration_number' => $this->business_registration_number,
            'business_type' =>  $this->business_type,
            'business_tax_id' => $this->business_tax_id,
            // 'business_logo' => isset($documentPaths['business_logo']) ? $documentPaths['business_logo'] : null,
            'business_contact_person' => $this->business_contact_person,
            'business_contact_number' =>  $this->business_contact_number,
            'id_number' => trim($this->id_number),
            'id_type' => $this->id_type,
            'position' => $this->position,
            'business_registration_date' => $this->business_registration_date,
            'is_information_verified' => false,
            'is_documents_verified' => false,
            'status' => 'pending',
        ]);
    }

    private function sendNotificationEmails($vehicleOwner)
    {
        BusinessRegistrationNotificationJob::dispatch($vehicleOwner, $this->email)->onQueue('sendMail');
    }

    private function cleanupUploadedFiles()
    {
        $files = ['id_document', 'business_registration_certificate', 'business_logo', 'tax_clearance', 'proof_of_address'];

        foreach ($files as $file) {
            if (isset($this->{$file}) && $this->{$file}) {
                try {
                    $this->{$file}->delete();
                } catch (\Exception $e) {
                    Log::warning("Failed to cleanup uploaded file {$file}: " . $e->getMessage());
                }
            }
        }
    }

    private function getLoggableUserData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'business_name' => $this->business_name,
            'current_step' => $this->currentStep,
        ];
    }

    public function resetForm()
    {
        $this->reset();
        $this->currentStep = 1;
        $this->mount();
        session()->flash('info', 'Form has been reset.');
    }

    public function canProceedToNextStep()
    {
        return $this->isStepCompleted($this->currentStep) && !$this->is_loading;
    }

    public function getStepTitle($step)
    {
        $titles = [
            1 => 'Business Information',
            2 => 'Business Details',
            3 => 'Document Upload',
            4 => 'Verification & Submit'
        ];

        return $titles[$step] ?? 'Step ' . $step;
    }

    public function getStepDescription($step)
    {
        $descriptions = [
            1 => 'Enter your personal and contact information',
            2 => 'Provide business details (if applicable)',
            3 => 'Upload required documents and certificates',
            4 => 'Verify your email and submit your registration'
        ];

        return $descriptions[$step] ?? '';
    }

    public function isStepCompleted($step)
    {
        try {
            switch ($step) {
                case 1:
                    return $this->validateStep1Fields();
                case 2:
                    return !$this->is_business_owner || $this->validateStep2Fields();
                case 3:
                    return $this->validateStep3Fields();
                case 4:
                    return $this->is_verified && $this->terms_accepted && $this->privacy_accepted;
                default:
                    return false;
            }
        } catch (\Exception $e) {
            Log::warning("Error checking step completion for step {$step}: " . $e->getMessage());
            return false;
        }
    }

    private function validateStep1Fields()
    {
        return !empty(trim($this->name)) &&
            !empty(trim($this->contact_number)) &&
            !empty(trim($this->email)) &&
            filter_var($this->email, FILTER_VALIDATE_EMAIL) &&
            !empty(trim($this->address)) &&
            !empty($this->vehicle_owner_type_id) &&
            !empty(trim($this->id_number)) &&
            !empty($this->id_type) &&
            in_array($this->id_type, array_keys($this->id_types));
    }

    private function validateStep2Fields()
    {
        if (!$this->is_business_owner) {
            return true;
        }

        return !empty(trim($this->business_name)) &&
            !empty($this->business_type) &&
            !empty(trim($this->business_registration_number)) &&
            !empty($this->business_registration_date) &&
            !empty(trim($this->position)) &&
            Carbon::parse($this->business_registration_date)->lessThanOrEqualTo(today());
    }

    private function validateStep3Fields()
    {
        $hasRequiredDocs = $this->id_document;

        if ($this->is_business_owner) {
            $hasRequiredDocs = $hasRequiredDocs && $this->business_registration_certificate;
        }

        return $hasRequiredDocs;
    }

    public function isStepAccessible($step)
    {
        if ($step <= 1) return true;

        for ($i = 1; $i < $step; $i++) {
            if (!$this->isStepCompleted($i)) {
                return false;
            }
        }

        return true;
    }

    // File upload event handlers
    public function updatedIdDocument()
    {
        $this->validateOnly('id_document');
    }

    public function updatedBusinessRegistrationCertificate()
    {
        $this->validateOnly('business_registration_certificate');
    }

    public function updatedBusinessLogo()
    {
        $this->validateOnly('business_logo');
    }

    public function updatedTaxClearance()
    {
        $this->validateOnly('tax_clearance');
    }

    public function updatedProofOfAddress()
    {
        $this->validateOnly('proof_of_address');
    }

    // Real-time validation for key fields
    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function updatedBusinessEmail()
    {
        if ($this->is_business_owner) {
            $this->validateOnly('business_email');
        }
    }

    public function updatedBusinessRegistrationNumber()
    {
        if ($this->is_business_owner) {
            $this->validateOnly('business_registration_number');
        }
    }
}

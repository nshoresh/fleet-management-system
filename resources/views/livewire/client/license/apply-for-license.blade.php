<!-- resources/views/livewire/apply-for-license.blade.php -->

<div>
    <h1>Apply for License</h1>

    <form wire:submit.prevent="submitApplication">
        <div>
            <label for="license-type">License Type:</label>
            <select id="license-type" wire:model="selectedLicenseType">
                @foreach($licenseTypes as $licenseType)
                    <option value="{{ $licenseType->id }}">{{ $licenseType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="application-number">Application Number:</label>
            <input id="application-number" type="text" wire:model="applicationNumber">
        </div>

        <div>
            <label for="submission-date">Submission Date:</label>
            <input id="submission-date" type="date" wire:model="submissionDate">
        </div>

        <div>
            <label for="expiry-date">Expiry Date:</label>
            <input id="expiry-date" type="date" wire:model="expiryDate">
        </div>

        <div>
            <label for="purpose">Purpose:</label>
            <textarea id="purpose" wire:model="purpose"></textarea>
        </div>

        <div>
            <label for="supporting-documents">Supporting Documents:</label>
            <input id="supporting-documents" type="file" wire:model="supportingDocuments">
        </div>

        <div>
            <label for="additional-information">Additional Information:</label>
            <textarea id="additional-information" wire:model="additionalInformation"></textarea>
        </div>

        <div>
            <label for="terms-accepted">Terms and Conditions:</label>
            <input id="terms-accepted" type="checkbox" wire:model="termsAccepted">
            <span>I accept the terms and conditions</span>
        </div>

        <button type="submit">Submit Application</button>
    </form>

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
</div>
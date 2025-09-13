<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'account_status_id',
        'user_type_id',
        'vehicle_owner_id',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = self::generateUniqueUuid();
            }
        });
    }

    public function account_status(): BelongsTo
    {
        return $this->belongsTo(AccountStatus::class);
    }

    public function user_type(): BelongsTo
    {
        return $this->belongsTo(
            UserType::class,
            'user_type_id',
            'id'
        );
    }

    public function isSystemUser()
    {
        return $this->user_type->access_code === '10000';
    }

    public function isClientUser()
    {
        return $this->user_type->access_code === '100001';
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role by slug.
     *
     * @param string $roleSlug
     * @return bool
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->role->slug === $roleSlug;
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param array $rolesSlugs
     * @return bool
     */
    public function hasAnyRole(array $rolesSlugs): bool
    {
        return in_array($this->role->slug, $rolesSlugs);
    }

    /**
     * Check if the user is a Super Admin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Check if the user is a System Admin.
     *
     * @return bool
     */
    public function isSystemAdmin(): bool
    {
        return $this->hasRole('system-admin');
    }

    /**
     * Check if the user is a Platform Administrator.
     *
     * @return bool
     */
    public function isPlatformAdmin(): bool
    {
        return $this->hasRole('platform-administrator');
    }

    /**
     * Check if the user is a Site Manager.
     *
     * @return bool
     */
    public function isSiteManager(): bool
    {
        return $this->hasRole('site-manager');
    }

    /**
     * Check if the user is a Fleet Manager.
     *
     * @return bool
     */
    public function isFleetManager(): bool
    {
        return $this->hasRole('fleet-manager');
    }

    /**
     * Check if the user is a Billing Manager.
     *
     * @return bool
     */
    public function isBillingManager(): bool
    {
        return $this->hasRole('billing-manager');
    }

    /**
     * Check if the user is a Clients Manager.
     *
     * @return bool
     */
    public function isClientsManager(): bool
    {
        return $this->hasRole('clients-manager');
    }

    /**
     * Check if the user is a Logistics Coordinator.
     *
     * @return bool
     */
    public function isLogisticsCoordinator(): bool
    {
        return $this->hasRole('logistics-coordinator');
    }

    /**
     * Check if the user is a Driver.
     *
     * @return bool
     */
    public function isDriver(): bool
    {
        return $this->hasRole('driver');
    }

    /**
     * Check if the user is a Maintenance Manager.
     *
     * @return bool
     */
    public function isMaintenanceManager(): bool
    {
        return $this->hasRole('maintenance-manager');
    }

    /**
     * Check if the user is a Dispatcher.
     *
     * @return bool
     */
    public function isDispatcher(): bool
    {
        return $this->hasRole('dispatcher');
    }

    /**
     * Check if the user is a Content Manager.
     *
     * @return bool
     */
    public function isContentManager(): bool
    {
        return $this->hasRole('content-manager');
    }

    /**
     * Check if the user is a Content Contributor.
     *
     * @return bool
     */
    public function isContentContributor(): bool
    {
        return $this->hasRole('content-contributor');
    }

    /**
     * Check if the user is a Registered User.
     *
     * @return bool
     */
    public function isRegisteredUser(): bool
    {
        return $this->hasRole('registered-user');
    }

    /**
     * Check if the user is a Guest User.
     *
     * @return bool
     */
    public function isGuestUser(): bool
    {
        return $this->hasRole('guest-user');
    }

    /**
     * Check if the user has admin privileges (Super Admin, System Admin, or Platform Administrator).
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole([
            'super-admin',
            'system-admin',
            'platform-administrator'
        ]);
    }

    /**
     * Check if the user has any management role.
     *
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->hasAnyRole([
            'site-manager',
            'fleet-manager',
            'billing-manager',
            'clients-manager',
            'maintenance-manager',
            'content-manager'
        ]);
    }

    /**
     * Check if user has fleet-related role.
     *
     * @return bool
     */
    public function hasFleetRole(): bool
    {
        return $this->hasAnyRole([
            'fleet-manager',
            'logistics-coordinator',
            'driver',
            'maintenance-manager',
            'dispatcher'
        ]);
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class, 'vehicle_owner_id', 'id');
    }

    public function isVehicleOwner(): bool
    {
        return $this->isClientUser() && $this->vehicle_owner_id  && $this->vehicleOwner()->exists();
    }



    public function isActive()
    {
        return $this->account_status_id == 1; // Assuming 1 is the ID for "active" status
    }

    public function isInactive()
    {
        return $this->account_status_id == 2; // Assuming 2 is the ID for "inactive" status
    }

    public function isSuspended()
    {
        return $this->account_status_id == 3; // Assuming 3 is the ID for "suspended" status
    }

    public function isDisabled()
    {
        return $this->account_status_id == 4; // Assuming 4 is the ID for "disabled" status
    }
    public function isDeleted()
    {
        return $this->account_status_id == 5; // Assuming 5 is the ID for "deleted" status
    }

    public function verified()
    {
        return $this->email_verified_at !== null;
    }
    public function unverified()
    {
        return $this->email_verified_at === null;
    }

    public function isVerified()
    {
        return $this->email_verified_at !== null;
    }
    public function isUnverified()
    {
        return $this->email_verified_at === null;
    }

    public function accountStatus()
    {
        return $this->belongsTo(AccountStatus::class, 'account_status_id', 'id');
    }
    public static function generateUniqueUuid(): string
    {
        do {
            $uuid = strtoupper(bin2hex(random_bytes(48)) . uniqid());
            $exists = self::where('uuid', $uuid)->exists();
        } while ($exists);

        return $uuid;
    }


    public function hasVerifiedEmail()
    {
        return $this->email_verified_at;
    }

    /**
     * Mark the given user's email as verified and activate their account.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'account_status_id' => 1, // Set account status to active (1) when email is verified
        ])->save();
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
    public function hasPermission(string $permissionSlug): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()
            ->where('slug', $permissionSlug)
            ->exists();
    }
}

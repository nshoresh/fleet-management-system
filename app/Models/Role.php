<?php

namespace App\Models;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[ObservedBy(RoleObserver::class)]
class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */


    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permisions::class, 'role_permissions', 'role_id', 'permission_id');
    }

    // Fix the hasPermission method
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()
            ->where('slug', $permissionSlug)
            ->exists();
    }

    // Fix the hasAnyPermission method
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        return $this->permissions()
            ->whereIn('slug', $permissionSlugs)
            ->exists();
    }

    /**
     * Get formatted status for display.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if the role is admin-level
     *
     * @return bool
     */
    public function isAdminLevel(): bool
    {
        return in_array(
            $this->slug,
            [
                'super-admin',
                'system-admin',
                'platform-administrator'
            ]
        );
    }

    /**
     * Check if the role is manager-level
     *
     * @return bool
     */
    public function isManagerLevel(): bool
    {
        return in_array($this->slug, [
            'site-manager',
            'fleet-manager',
            'billing-manager',
            'clients-manager',
            'maintenance-manager',
            'content-manager'
        ]);
    }

    /**
     * Check if the role is fleet-related
     *
     * @return bool
     */
    public function isFleetRelated(): bool
    {
        return in_array($this->slug, [
            'fleet-manager',
            'logistics-coordinator',
            'driver',
            'maintenance-manager',
            'dispatcher'
        ]);
    }



    public function scopeNonSystem($query)
    {

        $systemRoles = [
            'super-admin',
            'system-admin',
            'platform-administrator',
            'billing-manager',
            'clients-manager',
            'content-manager',
            'content-contributor'

        ];
        return $query
            ->whereNotIn('slug', $systemRoles);
    }

    public function scopeSystem($query)
    {

        $systemRoles = [
            'super-admin',
            'system-admin',
            'platform-administrator',
            'billing-manager',
            'clients-manager',
            'content-manager',
            'content-contributor'

        ];
        return $query
            ->whereIn('slug', $systemRoles);
    }

    public function hasPermissions(...$permissionSlugs)
    {
        //
    }
}

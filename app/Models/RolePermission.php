<?php

namespace App\Models;

use App\Observers\RolePermissionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(RolePermissionObserver::class)]
class RolePermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'permission_id',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function permission()
    {
        return $this->belongsTo(Permisions::class);
    }


    public function getRolePermissionsCountAttribute()
    {
        return $this->rolePermissions->count();
    }
}

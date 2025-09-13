<?php

namespace App\Models;

use App\Observers\PermisionsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PermisionsObserver::class)]

class Permisions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permissions';
    protected $fillable = ['name', 'slug', 'description', 'group'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'permission_id', 'user_id');
    }

    public function getRolesCountAttribute()
    {
        return $this->roles->count();
    }


    public function getUsersCountAttribute()
    {
        return $this->users->count();
    }


    public function getActiveUsersCountAttribute()
    {
        return $this->users->where('account_status_id', 1)->count();
    }
}

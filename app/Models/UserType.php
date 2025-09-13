<?php

namespace App\Models;

use App\Observers\UserTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(UserTypeObserver::class)]

class UserType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'slug',
        'description',
        'access_code'
    ];

    public function users(): HasMany
    {
        return $this->has(User::class);
    }
}

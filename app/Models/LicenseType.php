<?php

namespace App\Models;

use App\Observers\LicenseTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(LicenseTypeObserver::class)]

class LicenseType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_name',
        'type_description',
        'type_category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function licenseApplications()
    {
        return $this->hasMany(LicenseApplication::class);
    }




    public function getLicensesCountAttribute()
    {
        return $this->licenses->count();
    }
}

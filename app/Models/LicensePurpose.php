<?php

namespace App\Models;

use App\Observers\LicensePurposeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(LicensePurposeObserver::class)]

class LicensePurpose extends Model
{
    use HasFactory;

    protected $fillable = [
        'purpose_name',
        'purpose_description',
        'purpose_category',
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


    public function getLicensesCountAttribute()
    {
        return $this->licenses->count();
    }
}

<?php

namespace App\Models;

use App\Observers\VehicleDocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(VehicleDocumentObserver::class)]
class VehicleDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'vehicle_owner_id',
        'attachment_category', // e.g., 'document', 'image'
        'attachment', // e.g., 'registration', 'insurance', 'inspection', vehicle image.
        'image_type', // e.g., 'exterior', 'interior', frotnt, back, side
        'file_name',
        'notes',
        'issue_date',
        'is_verified',
    ];
    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_verified' => 'boolean',
    ];


    protected $appends = [
        'file_url',
        'file_size_formatted',
        'issue_date_formatted',
        'is_verified_label',
    ];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class);
    }

    // Automatically calculate the expiry date based on the issue date
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($document) {
            if ($document->issue_date && !$document->expiry_date) {
                $document->expiry_date = $document->issue_date->copy()->addDays(365);
            }
        });
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path; // Assuming file_path is the URL to the file in Google Cloud Storage
    }

    public function getFileSizeFormattedAttribute()
    {
        return number_format($this->file_size / 1024, 2) . ' KB'; // Convert bytes to KB
    }

    public function getIssueDateFormattedAttribute()
    {
        return $this->issue_date ? $this->issue_date->format('Y-m-d') : null; // Format the issue date
    }

    public function getIsVerifiedLabelAttribute()
    {
        return $this->is_verified ? 'Verified' : 'Not Verified'; // Return a label based on verification status
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true); // Scope to filter verified documents
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false); // Scope to filter unverified documents
    }
}

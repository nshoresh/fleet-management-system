<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseDocument extends Model
{
    protected $fillable = [
        'license_application_id',
        'file_path',
        'uploaded_by',
    ];

    public function licenseApplication(): BelongsTo
    {
        return $this->belongsTo(LicenseApplication::class);
    }
}

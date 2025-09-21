<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LicenseDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_application_id',
        'file_path',
        'uploaded_by',
    ];

    // ✅ Auto-generate full URL
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Relationships
    public function application()
    {
        return $this->belongsTo(LicenseApplication::class, 'license_application_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
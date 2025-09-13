<?php

namespace App\Models;

use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(InvoiceObserver::class)]

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'vehicle_owner_id',
        'amount',
        'currency',
        'invoice_date',
        'due_date',
        'status',
        'notes',
        'terms_and_conditions',
        'payment_method',
        'paid_at',
        'tax_amount',
        'discount_amount',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

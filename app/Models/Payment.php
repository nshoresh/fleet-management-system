<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PaymentObserver::class)]
class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_number',
        'invoice_id',
        'vehicle_owner_id',
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_reference',
        'payment_date',
        'notes',
        'receipt_number',
        'is_verified',
        'verified_by',
        'verified_at',
        'payer_name',
        'payer_contact',
        'payment_meta',
        'bank_name',
        'check_number',
        'card_last_four',
        'card_type',
        'is_reconciled',
        'reconciled_by',
        'reconciled_at',
        'is_partial_payment',
        'remaining_balance',
        'is_refunded',
        'refunded_amount',
        'refunded_at',
        'refunded_by',
        'refund_reference',
        'refund_reason',
    ];

    protected $casts = [
        'payment_meta' => 'array',
        'verified_at' => 'datetime',
        'reconciled_at' => 'datetime',
        'refunded_at' => 'datetime',
        'payment_date' => 'date',
        'is_verified' => 'boolean',
        'is_reconciled' => 'boolean',
        'is_partial_payment' => 'boolean',
        'is_refunded' => 'boolean',
    ];

    // Relationships
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function vehicleOwner(): BelongsTo
    {
        return $this->belongsTo(VehicleOwner::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function reconciledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciled_by');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }
}

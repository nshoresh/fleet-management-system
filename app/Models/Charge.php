<?php

namespace App\Models;

use App\Observers\ChargeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ChargeObserver::class)]
class Charge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_owner_id',
        'amount',
        'description',
        'reference_number',
        'status',
        'due_date',
        'payment_date',
        'payment_method',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The possible status values for charges.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_INVOICED = 'Invoiced';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Get all possible status values.
     *
     * @return array<string>
     */


    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_INVOICED,
            self::STATUS_CANCELLED,
        ];
    }

    /**
     * Get the vehicle owner that owns the charge.
     */
    public function vehicleOwner(): BelongsTo
    {
        return $this->belongsTo(VehicleOwner::class);
    }

    /**
     * Get the user who created the charge.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the charge.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include pending charges.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include invoiced charges.
     */
    public function scopeInvoiced($query)
    {
        return $query->where('status', self::STATUS_INVOICED);
    }

    /**
     * Scope a query to only include cancelled charges.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope a query to only include overdue charges.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include paid charges.
     */
    public function scopePaid($query)
    {
        return $query->whereNotNull('payment_date');
    }

    /**
     * Scope a query to only include unpaid charges.
     */
    public function scopeUnpaid($query)
    {
        return $query->whereNull('payment_date');
    }

    /**
     * Check if the charge is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the charge is invoiced.
     */
    public function isInvoiced(): bool
    {
        return $this->status === self::STATUS_INVOICED;
    }

    /**
     * Check if the charge is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if the charge is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->isPending();
    }

    /**
     * Check if the charge has been paid.
     */
    public function isPaid(): bool
    {
        return !is_null($this->payment_date);
    }

    /**
     * Mark the charge as paid.
     */
    public function markAsPaid(string $paymentMethod = null, \Carbon\Carbon $paymentDate = null): void
    {
        $this->update([
            'payment_date' => $paymentDate ?? now(),
            'payment_method' => $paymentMethod,
            'status' => self::STATUS_INVOICED,
        ]);
    }

    /**
     * Get the formatted amount with currency symbol.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Get the status in a human-readable format.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_INVOICED => 'Invoiced',
            self::STATUS_CANCELLED => 'Cancelled',
            default => ucfirst($this->status),
        };
    }
}

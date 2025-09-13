<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class FeeCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the fees that belong to this category.
     */
    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Get the charges that belong to fees in this category.
     */
    public function charges(): HasMany
    {
        return $this->hasManyThrough(Charge::class, Fee::class);
    }

    /**
     * Scope a query to search fee categories by name.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Scope a query to order by name.
     */
    public function scopeOrderByName(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('name', $direction);
    }

    /**
     * Scope a query to only include categories that have fees.
     */
    public function scopeWithFees(Builder $query): Builder
    {
        return $query->has('fees');
    }

    /**
     * Scope a query to only include categories that have no fees.
     */
    public function scopeWithoutFees(Builder $query): Builder
    {
        return $query->doesntHave('fees');
    }

    /**
     * Get the total number of fees in this category.
     */
    public function getFeesCountAttribute(): int
    {
        return $this->fees()->count();
    }

    /**
     * Get the total amount of all fees in this category.
     */
    public function getTotalFeesAmountAttribute(): float
    {
        return $this->fees()->sum('amount') ?? 0;
    }

    /**
     * Get the formatted total amount with currency symbol.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '$' . number_format($this->getTotalFeesAmountAttribute(), 2);
    }

    /**
     * Check if this category has any fees.
     */
    public function hasFees(): bool
    {
        return $this->fees()->exists();
    }

    /**
     * Check if this category can be safely deleted.
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasFees();
    }

    /**
     * Get a short description for display purposes.
     */
    public function getShortDescriptionAttribute(): string
    {
        if (!$this->description) {
            return '';
        }

        return strlen($this->description) > 100
            ? substr($this->description, 0, 100) . '...'
            : $this->description;
    }

    /**
     * Get the category name in title case.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucwords(strtolower($this->name));
    }

    /**
     * Common fee category names as constants.
     */
    public const REGISTRATION = 'Registration';
    public const LATE_PAYMENT = 'Late Payment';
    public const PROCESSING = 'Processing';
    public const PENALTY = 'Penalty';
    public const INSPECTION = 'Inspection';
    public const RENEWAL = 'Renewal';
    public const TRANSFER = 'Transfer';
    public const DUPLICATE = 'Duplicate';

    /**
     * Get all predefined category names.
     *
     * @return array<string>
     */
    public static function getPredefinedCategories(): array
    {
        return [
            self::REGISTRATION,
            self::LATE_PAYMENT,
            self::PROCESSING,
            self::PENALTY,
            self::INSPECTION,
            self::RENEWAL,
            self::TRANSFER,
            self::DUPLICATE,
        ];
    }

    /**
     * Create or get a fee category by name.
     */
    public static function findOrCreateByName(string $name, string $description = null): self
    {
        return static::firstOrCreate(
            ['name' => $name],
            ['description' => $description]
        );
    }

    /**
     * Get the most used fee categories.
     */
    public static function getMostUsed(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return static::withCount('fees')
            ->orderBy('fees_count', 'desc')
            ->limit($limit)
            ->get();
    }
}

<?php

namespace App\Models;

use App\Observers\VehicleClassificationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

#[ObservedBy(VehicleClassificationObserver::class)]
class VehicleClassification extends Model
{
    use HasFactory;

    protected $fillable = [
        'classification_name',
        'min_weight',
        'max_weight',
        'rdc_fee',
        'description',
        'is_active',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->validateWeightRanges();
        });
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function getFormattedWeightRangeAttribute(): string
    {
        switch ($this->classification_name) {
            case 'Articulated Vehicles':
                return 'Any weight';

            case 'Heavy Truck':
                return '10,000 and above';

            case 'Medium Truck':
                return '6,000 to 9,999.99';

            case 'Light Truck':
                return '3,500 to 5,999.99';

            case 'Passenger Cars and Utes':
                return 'Up to 3,499.99';

            case 'Public Motor Vehicles':
                return 'Any weight';

            default:
                $min = $this->min_weight
                    ? number_format($this->min_weight, $this->min_weight == intval($this->min_weight) ? 0 : 2) . ' kg'
                    : '-';
                $max = $this->max_weight
                    ? number_format($this->max_weight, $this->max_weight == intval($this->max_weight) ? 0 : 2) . ' kg'
                    : '-';
                return "$min to $max";
        }
    }

    /**
     * Validate that the weight range doesn't overlap with existing classifications
     *
     * @throws ValidationException
     *//*
    public function validateWeightRanges(): void
    {
        // Skip validation for classifications with "Any weight"
        if (in_array($this->classification_name, ['Articulated Vehicles', 'Public Motor Vehicles'])) {
            return;
        }

        // Validate that min_weight is less than max_weight
        if ($this->min_weight && $this->max_weight && $this->min_weight >= $this->max_weight) {
            throw ValidationException::withMessages([
                'min_weight' => 'Minimum weight must be less than maximum weight',
                'max_weight' => 'Maximum weight must be greater than minimum weight',
            ]);
        }

        // Check for overlapping ranges with other classifications
        $overlapping = self::where('id', '!=', $this->id)
            ->where(function ($query) {
                // Case 1: New range starts within an existing range
                $query->where(function ($q) {
                    $q->where('min_weight', '<=', $this->min_weight)
                      ->where('max_weight', '>=', $this->min_weight);
                })
                // Case 2: New range ends within an existing range
                ->orWhere(function ($q) {
                    $q->where('min_weight', '<=', $this->max_weight)
                      ->where('max_weight', '>=', $this->max_weight);
                })
                // Case 3: New range completely contains an existing range
                ->orWhere(function ($q) {
                    $q->where('min_weight', '>=', $this->min_weight)
                      ->where('max_weight', '<=', $this->max_weight);
                });
            })
            ->exists();

        if ($overlapping) {
            throw ValidationException::withMessages([
                'min_weight' => 'This weight range overlaps with an existing vehicle classification',
                'max_weight' => 'This weight range overlaps with an existing vehicle classification',
            ]);
        }
    }*/
}

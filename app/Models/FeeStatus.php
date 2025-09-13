<?php

namespace App\Models;

use App\Observers\FeeStatusObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(FeeStatusObserver::class)]

class FeeStatus extends Model
{
    use HasFactory;


    public function fees()
    {
        return $this->hasMany(FeeCategory::class);
    }
}

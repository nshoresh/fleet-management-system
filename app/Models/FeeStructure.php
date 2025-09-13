<?php

namespace App\Models;

use App\Observers\FeeStructureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(FeeStructureObserver::class)]

class FeeStructure extends Model
{
    use HasFactory;


    public function fee()
    {
        return $this->belongsTo(FeeCategory::class);
    }
}

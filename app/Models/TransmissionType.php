<?php

namespace App\Models;

use App\Observers\TransmissionTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TransmissionTypeObserver::class)]

class TransmissionType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}

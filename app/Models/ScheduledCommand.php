<?php

namespace App\Models;

use App\Observers\ScheduledCommandObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ScheduledCommandObserver::class)]

class ScheduledCommand extends Model
{
    use HasFactory;
}

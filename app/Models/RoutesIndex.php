<?php

namespace App\Models;

use App\Observers\RoutesIndexObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(RoutesIndexObserver::class)]

class RoutesIndex extends Model
{
    use HasFactory;

    // If the table name is different from the plural form of the model name
    protected $table = 'routes_index';

    // Define fillable columns for mass assignment
    protected $fillable = ['uri', 'name'];


    // Define relationships
}

<?php

namespace App\Models;

use App\Observers\AccountStatusObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(AccountStatusObserver::class)]
class AccountStatus extends Model
{
    use HasFactory;
    protected $table = 'account_statuses';
    protected $fillable =
    [
        'status',
        'description'
    ];


    protected $appends = ['accounts_count'];


    public function accounts()
    {
        return $this->hasMany(User::class);
    }

    public function getAccountsCountAttribute(): int
    {
        return $this->accounts()->count();
    }
}

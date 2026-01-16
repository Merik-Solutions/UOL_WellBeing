<?php

namespace App\Traits;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasBankAccount
{

    public function bank_account(): MorphOne
    {
        return $this->morphOne(BankAccount::class, 'owner');
    }
}

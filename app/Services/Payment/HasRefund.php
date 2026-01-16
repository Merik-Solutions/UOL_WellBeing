<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Transaction;

interface HasRefund
{
    public function MakeRefund(Transaction $transaction);
}

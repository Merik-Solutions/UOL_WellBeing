<?php

namespace App\Enums\MyFatoorah;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self TransactionsStatusChanged()
 * @method static self RefundStatusChanged()
 * @method static self BalanceTransferred()
 * @method static self SupplierStatusChanged()
 * @method static self RecurringStatusChanged()
 */
final class WebHookEventType extends Enum
{
    protected static function values()
    {
        return [
            'TransactionsStatusChanged' => 1,
            'RefundStatusChanged' => 2,
            'BalanceTransferred' => 3,
            'SupplierStatusChanged' => 4,
            'RecurringStatusChanged' => 5,
        ];
    }
}

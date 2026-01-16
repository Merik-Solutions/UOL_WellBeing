<?php

namespace App\Repositories\interfaces;

use App\Models\Reservation;
use App\Models\Transaction;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\FuncCall;

/**
 * Interface TransactionRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface TransactionRepository extends BaseInterface
{
    public function forPatients();
    public function forDoctors();
}

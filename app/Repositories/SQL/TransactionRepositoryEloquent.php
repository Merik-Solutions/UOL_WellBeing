<?php

namespace App\Repositories\SQL;

use App\Models\Patient;
use App\Models\Reservation;
use App\Repositories\SQL\BaseRepository;
use App\Services\Facades\PayTabs;
use Illuminate\Validation\ValidationException;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\TransactionRepository;
use App\Models\Transaction;

// use App\Validators\TransactionValidator;

/**
 * Class TransactionRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class TransactionRepositoryEloquent extends BaseRepository implements
    TransactionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function forPatients()
    {
        return $this->scopeQuery(fn($q) => $q->forPatients());
    }
    public function forDoctors()
    {
        return $this->scopeQuery(fn($q) => $q->forDoctors());
    }
}

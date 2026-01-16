<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Carbon\Carbon;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\PrescriptionRepository;
use App\Models\Prescription;

// use App\Validators\PrescriptionValidator;

/**
 * Class PrescriptionRepositoryEloquent.
 * @package namespace App\Repositories\SQL;
 */
class PrescriptionRepositoryEloquent extends BaseRepository implements
    PrescriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Prescription::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

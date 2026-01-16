<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\DoctorPackageRepository;
use App\Models\DoctorPackage;
// use App\Validators\DoctorPackageValidator;

/**
 * Class DoctorPackageRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class DoctorPackageRepositoryEloquent extends BaseRepository implements
    DoctorPackageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DoctorPackage::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use App\Models\UserDoctorPackage;
// use App\Validators\UserDoctorPackageValidator;

/**
 * Class UserDoctorPackageRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class UserDoctorPackageRepositoryEloquent extends BaseRepository implements
    UserDoctorPackageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserDoctorPackage::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\PackageRepository;
use App\Models\Package;
// use App\Validators\PackageValidator;

/**
 * Class PackageRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class PackageRepositoryEloquent extends BaseRepository implements
    PackageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Package::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function isActive()
    {
        return $this->scopeQuery(
            fn($q) => $q->where('isActive', 1)
        );
    }
}

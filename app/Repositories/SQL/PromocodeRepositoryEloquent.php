<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\PromocodeRepository;
use App\Models\Promocode;
// use App\Validators\PromocodeValidator;

/**
 * Class PromocodeRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class PromocodeRepositoryEloquent extends BaseRepository implements
    PromocodeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Promocode::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

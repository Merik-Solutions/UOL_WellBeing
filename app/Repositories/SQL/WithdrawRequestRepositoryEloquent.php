<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\WithdrawRequestRepository;
use App\Models\WithdrawRequest;
// use App\Validators\WithdrawRequestValidator;

/**
 * Class WithdrawRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class WithdrawRequestRepositoryEloquent extends BaseRepository implements
    WithdrawRequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WithdrawRequest::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

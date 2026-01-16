<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\RefundRequestRepository;
use App\Models\RefundRequest;
// use App\Validators\RefundRequestValidator;

/**
 * Class RefundRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class RefundRequestRepositoryEloquent extends BaseRepository implements RefundRequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RefundRequest::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}

<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ActivePromocodeCriteria.
 *
 * @package namespace App\Criteria;
 */
class IsActiveCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param \App\Models\Promocode|\App\Models\UserDoctorPackage $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->IsValid()->isAvailable();
    }
}

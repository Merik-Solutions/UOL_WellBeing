<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OfCategoryCriteria.
 *
 * @package namespace App\Criteria;
 */
class OfCategoryCriteria implements CriteriaInterface
{
    protected $category_id;

    public function __construct($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param App\Model\Category              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->ofCategory($this->category_id);
    }
}

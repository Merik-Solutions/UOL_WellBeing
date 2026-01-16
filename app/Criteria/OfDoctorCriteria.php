<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OfDoctorCriteria.
 *
 * @package namespace App\Criteria;
 */
class OfDoctorCriteria implements CriteriaInterface
{
    protected $doctor_id;

    public function __construct($doctor_id)
    {
        $this->doctor_id = $doctor_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Illuminate\Database\Eloquent\Model              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->ofDoctor($this->doctor_id);
    }
}

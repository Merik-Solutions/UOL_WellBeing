<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OfPatientCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class OfPatientCriteria implements CriteriaInterface
{
    protected $patient;

    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \App\Models\Reservation              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->ofPatient($this->patient);
    }
}

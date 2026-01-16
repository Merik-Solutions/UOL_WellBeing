<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\OfPatientCriteria;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ShouldHavePatientId;
use App\Http\Resources\Presciption\PrescriptionResource;
use App\Repositories\interfaces\PrescriptionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrescriptionController extends Controller
{
    public $repo;

    public function __construct(PrescriptionRepository $repo)
    {
        $this->middleware(ShouldHavePatientId::class)->except('show');
        $repo->pushCriteria(new OfPatientCriteria(request('patient_id')));
        $this->repo = $repo;
    }

    public function index()
    {
        $prescriptions = $this->repo
            ->queryBuilder()
            ->allowedFilters(
                filters: [
                    'description',
                    'diagnosis',
                    AllowedFilter::exact(name: 'code'),
                    AllowedFilter::exact(name: 'patient_id'),
                    AllowedFilter::exact(name: 'doctor_id'),
                ],
            )
            ->allowedSorts(
                sorts: [
                    AllowedSort::field(
                        name: 'date',
                        internalName: 'created_at',
                    ),
                ],
            )
            ->ofPatient(request('patient_id'))
            ->with(['items', 'patient', 'doctor'])
            ->paginate();
        return responseJson(
            [
                'prescription' => PrescriptionResource::collection(
                    $prescriptions,
                ),
            ],
            __('Loaded Successfully'),
        );
    }

    public function show($prescription_id)
    {
        try {
            $prescription = $this->repo
                ->with(['doctor', 'items', 'patient'])
                ->find($prescription_id);
        } catch (ModelNotFoundException $e) {
            return responseJson(
                null,
                __("Pescription Haven't added yet "),
                404,
            );
        }

        return responseJson(
            new PrescriptionResource($prescription),
            __('Loaded Successfully'),
        );
    }
}

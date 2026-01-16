<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Prescription\PrescriptionRequest;
use App\Http\Resources\Presciption\PrescriptionResource;
use App\Models\Prescription;
use App\Models\Reservation;
use App\Notifications\NewPrescriptionAdded;
use App\Repositories\interfaces\PrescriptionRepository;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public $repo;

    public function __construct(PrescriptionRepository $repo)
    {
        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(auth('doctor_api')->id()),
        );
    }

    public function index()
    {
        return responseJson(
            PrescriptionResource::collection($this->repo->paginate(10)),
            __('Loaded Successfully'),
        );
    }

    /**
     * get prescription for reservation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'reservation_id' => [
                'required',
                'integer',
                'exists:prescriptions,reservation_id',
                'exists:reservations,id,doctor_id,' .
                auth()->id() .
                ',status,' .
                Reservation::STATUS_FINISHED,
            ],
        ]);

        $prescription = $this->repo
            ->findByField('reservation_id', $request->reservation_id)
            ->first();
        $prescription = new PrescriptionResource(
            $prescription->load('patient', 'items', 'doctor'),
        );

        return responseJson(compact('prescription'), __('Loaded Successfully'));
    }

    /**
     * get prescription for reservation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(PrescriptionRequest $request)
    {
        $prescription = $this->repo->updateOrCreate(
            ['id' => $request->prescription_id],
            $request->validated(),
        );
        /** @var Prescription $prescription */
        $prescription->items()->createMany($request->items ?? []);

        $prescription->patient->user->notify(
            new NewPrescriptionAdded($prescription),
        );

        $prescription = new PrescriptionResource(
            $prescription->fresh()->load('user', 'doctor', 'items'),
        );

        return responseJson($prescription, __('Saved Successfully'));
    }

    /**
     * get prescription for reservation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Prescription $prescription)
    {
        $prescription->delete();

        return responseJson(null, __('Deleted Successfully'));
    }
}

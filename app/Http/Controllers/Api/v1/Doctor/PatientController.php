<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Criteria\OfPatientCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Note\NoteResource;
use App\Http\Resources\Patient\PatientResource;
use App\Http\Resources\Presciption\PrescriptionResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Http\Resources\users\UserResource;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\SendMessageToPatient;
use App\Repositories\interfaces\ChatRepository;
use App\Repositories\interfaces\NoteRepository;
use App\Repositories\interfaces\PatientRepository;
use App\Repositories\interfaces\PrescriptionRepository;
use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\interfaces\UserRepository;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(
        ReservationRepository $reservationRepo,
        ChatRepository $chatRepo,
        PrescriptionRepository $prescriptionRepo,
        NoteRepository $noteRepo,
        PatientRepository $patientRepo,
    ) {
        $chats_patient = $chatRepo
            ->where('doctor_id', auth()->id())
            ->pluck('patient_id');

        $reservations_patient = $reservationRepo
            ->where('doctor_id', auth()->id())
            ->pluck('patient_id');

        $notes_patient = $noteRepo
            ->where('doctor_id', auth()->id())
            ->pluck('patient_id');

        $prescriptions_patient = $prescriptionRepo
            ->where('doctor_id', auth()->id())
            ->pluck('patient_id');
        $patients_id = collect([])
            ->merge($reservations_patient)
            ->merge($notes_patient)
            ->merge($prescriptions_patient)
            ->merge($chats_patient)
            ->unique()
            ->values();

        $patients = $patientRepo
            ->whereIn('id', $patients_id->toArray())
            ->paginate(10);
        return responseJson(
            PatientResource::collection($patients),

            __('loaded successfully'),
        );
    }
    public function show($patient_id, PatientRepository $patientRepo)
    {
        $patient = $patientRepo->find($patient_id);

        return responseJson(
            [
                'patient' => new PatientResource($patient),
                // 'prescriptions' => PrescriptionResource::collection($prescriptions),
                // 'notes' => NoteResource::collection($notes),
            ],
            __('loaded successfully'),
        );
    }

    public function getNotes($patient_id, NoteRepository $noteRepo)
    {
        $notes = $noteRepo
            ->pushCriteria(new OfDoctorCriteria(auth()->id()))
            ->pushCriteria(new OfPatientCriteria($patient_id))
            ->paginate(10);
        return responseJson($notes, __('Loaded Successfully'));
    }

    public function getPrescriptions(
        $patient_id,
        PrescriptionRepository $prescriptionRepo,
    ) {
        $prescriptions = $prescriptionRepo
            ->pushCriteria(new OfDoctorCriteria(auth()->id()))
            ->pushCriteria(new OfPatientCriteria($patient_id))
            ->with('items')
            ->paginate(10);

        return responseJson(
            PrescriptionResource::collection($prescriptions),
            __('Loaded Successfully'),
        );
    }

    public function getReservations(
        $patient_id,
        ReservationRepository $reservationRepo,
    ) {
        $reservations = $reservationRepo
            ->pushCriteria(new OfDoctorCriteria(auth()->id()))
            ->pushCriteria(new OfPatientCriteria($patient_id))
            ->paginate(10);
        return responseJson(
            ReservationResource::collection($reservations),
            __('Loaded Successfully'),
        );
    }

    public function notifyPatient(User $patient, Request $request)
    {
        $request->validate(['sms' => ['required', 'string']]);
        $patient->notify(new SendMessageToPatient($request->sms));

        return responseJson(null, __('Message Sent Successfully'));
    }
}

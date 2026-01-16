<?php

namespace App\Observers;

use App\Models\MedicalHistory;
use App\Models\Prescription;
use Carbon\Carbon;

class PrescriptionObserver
{
    public function saving(Prescription $prescription)
    {
        $prescription->code = rand(000000000, 999999999);

        MedicalHistory::create([
            'patient_id' => $prescription->patient_id,
            'creator_type' => 'doctors',
            'creator_id' => $prescription->doctor_id,
            'reservation_id' => $prescription->reservation_id,
            'title' => $prescription->diagnosis,
            'date' => Carbon::now(),
            'description' => $prescription->description,
        ]);
    }
}

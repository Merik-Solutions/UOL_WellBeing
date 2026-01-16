<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Patient\PatientRequest;
use App\Http\Resources\Patient\PatientResource;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        return responseJson(
            PatientResource::collection(auth()->user()->patients)
        );
    }
    public function store(PatientRequest $request)
    {
        $attributes = $request->validated();
        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'patients');
        }
        $patient = auth()
            ->user()
            ->patients()
            ->create($attributes);
        return responseJson(
            new PatientResource($patient),
            __('Saved Successfully')
        );
    }

    public function update(Patient $patient, PatientRequest $request)
    {
        $attributes = $request->validated();
        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'patients');
        }
        $patient->update($attributes);
        return responseJson(
            new PatientResource($patient->refresh()),
            __('Updated Successfully')
        );
    }

    public function destroy(Patient $patient)
    {
        $patient = $patient->delete();
        return responseJson(null, __('Deleted Successfully'));
    }
}

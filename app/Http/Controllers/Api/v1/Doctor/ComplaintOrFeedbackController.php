<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Complaint\DisputedResource;
use App\Models\ComplaintOrFeedback;
use Illuminate\Http\Request;

class ComplaintOrFeedbackController extends Controller
{
    public function getDisputedAppointment(Request $request){
    
        $disputed = ComplaintOrFeedback::with(
            ['patient:id,user_id,name,image',
            'reservation',
             'messagePackage',
            'remarks_history'])
        ->where('doctor_id',$request->doctor_id)->orderBy('updated_at', 'DESC')->get();

        return responseJson(
           [ 'disputed_appointment' => DisputedResource::collection($disputed)],
            __('Loaded successfully'),
        );
    }
}

<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Package\PackageResource;
use App\Http\Resources\users\UserResource;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\User;
use App\Models\UserDoctorPackage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $sender = $this->messages()->select('sender_id','sender_type')->orderBy('id', 'desc')->first();
        return [
            'id' => $this->id,
            'messages' => MessageResource::collection(
                $this->whenLoaded('messages'),
            ),
            'last_message' => optional(
                $this->messages()
                    ->orderBy('id', 'desc')
                    ->first(),
            )->message,
            'sender_type' => isset($sender->sender_type)&&$sender->sender_type == User::class ? 'patient' : 'doctor',
            'unseen_messages' => $this->messages()
                ->where('sender_type', Doctor::class)
                ->where('seen_at', '!=', null)
                ->count(),
            'available_to_send' => (int)$this->available_to_send,
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'user' => new UserResource($this->whenLoaded('user')),
            'patient' => new UserResource($this->whenLoaded('patient')),
            'last_package' => new PackageResource($this->getPackage()),
        ];
    }

    /**
     * @return Package|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function getPackage(): mixed
    {
        return UserDoctorPackage::where('doctor_id', $this->doctor_id)->where('patient_id', $this->patient_id)->latest()->first()?->package ?? new Package();
    }
}

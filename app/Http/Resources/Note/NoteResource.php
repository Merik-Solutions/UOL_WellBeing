<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'diagnosis' => $this->diagnosis,
            'allergy' => $this->allergy,
            'patient' => $this->whenLoaded(
                'patient',
                fn() => [
                    'id' => $this->patient_id,
                    'name' => $this->patient?->name,
                ],
            ),
            'date' => $this->created_at->toDateString(),
        ];
    }
}

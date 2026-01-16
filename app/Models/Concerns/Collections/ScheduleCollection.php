<?php

namespace App\Models\Concerns\Collections;

use Illuminate\Database\Eloquent\Collection;

class ScheduleCollection extends Collection
{
    public function appointments()
    {
        $this->load('doctor', 'reservations');

        return $this->map->appointments->flatten(1);
    }
}

<?php

namespace App\Models\Concerns\SortsFields;

use DB;
use Illuminate\Database\Eloquent\Builder;

class ReservationsCount implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->orderBy(
            column: \Illuminate\Support\Facades\DB::raw(
                '(select count(id) from reservations where doctor_id = doctors.id group by doctor_id limit 1)',
            ),
            direction: $descending ? 'desc' : 'asc',
        );
    }
}

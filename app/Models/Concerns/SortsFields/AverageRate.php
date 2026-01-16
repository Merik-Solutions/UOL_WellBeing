<?php

namespace App\Models\Concerns\SortsFields;

use DB;
use Illuminate\Database\Eloquent\Builder;

class AverageRate implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->orderBy(
            column: DB::raw(
                '(select AVG(rate) from ratings where doctor_id = doctors.id group by doctor_id limit 1)',
            ),
            direction: $descending ? 'desc' : 'asc',
        );
    }
}

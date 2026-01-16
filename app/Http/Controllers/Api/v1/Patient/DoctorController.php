<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\OfCategoryCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DoctorCollection;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\Concerns\SortsFields\AverageRate;
use App\Models\Concerns\SortsFields\ReservationsCount;
use App\Repositories\interfaces\DoctorRepository;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Log;

class DoctorController extends Controller
{
    private $repo;

    /**
     * DoctorController constructor.
     * @param DoctorRepository $repo
     */
    public function __construct(DoctorRepository $repo)
    {
        $this->repo = $repo->scopeQuery(fn($doctors) => $doctors->isActive());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($category_id)
    {
        $this->repo->pushCriteria(new OfCategoryCriteria($category_id));
        $doctors = $this->repo
            ->queryBuilder()
            ->isActive()
            ->allowedFilters([
                AllowedFilter::exact('name_ar'),
                AllowedFilter::exact('name_en'),
                AllowedFilter::scope('name', 'ofName'),
                AllowedFilter::exact('expirence'),
            ])
            ->allowedSorts([
                AllowedSort::field('name_ar'),
                AllowedSort::field('name_en'),
                AllowedSort::field('expirence'),
                AllowedSort::field('price'),
                AllowedSort::custom('rating', new AverageRate()),
//                AllowedSort::custom('reservations', new ReservationsCount()),
            ])
            ->defaultSort(
                AllowedSort::custom(
                    'rating',
                    new AverageRate(),
                )->defaultDirection(SortDirection::DESCENDING),
            )
            ->ofCategory($category_id)
            ->with('ratings')
            ->paginate(10);

            $doctors->isDoctor = false;
        return responseJson(
            DoctorResource::collection($doctors),
            __('Loaded Successfully'),
        );
    }

    public function show($doctor_id)
    {
        return responseJson(
            new DoctorResource(
                $this->repo
                    ->with(['ratings:doctor_id,id,rate'])
                    ->find($doctor_id),
            ),
            __('Loaded Successfully'),
        );
    }
}

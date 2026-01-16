<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\IsActiveCriteria;
use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promocode\StorePromocodeRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Promocode\PromocodeResource;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\PromocodeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PromocodeController extends Controller
{
    public $repo;

    public function __construct(PromocodeRepository $repo)
    {
        $this->repo = $repo->pushCriteria(IsActiveCriteria::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check(Request $request)
    {
        try {
            $promocode = $this->repo
                ->where('code', $request->code)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return responseJson(null, __('Invalid Promocode'), 404);
        }

        return responseJson(
            new PromocodeResource($promocode),
            __('Loaded Successfully'),
        );
    }
}

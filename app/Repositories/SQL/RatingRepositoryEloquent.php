<?php

namespace App\Repositories\SQL;

use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\SQL\BaseRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\RatingRepository;
use App\Models\Rating;

// use App\Validators\RatingValidator;

/**
 * Class RatingRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class RatingRepositoryEloquent extends BaseRepository implements
    RatingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Rating::class;
    }
}

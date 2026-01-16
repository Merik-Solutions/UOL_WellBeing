<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\AdminNotificationRepository;
use App\Models\AdminNotification;
// use App\Validators\AdminNotificationValidator;

/**
 * Class AdminNotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class AdminNotificationRepositoryEloquent extends BaseRepository implements
    AdminNotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminNotification::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

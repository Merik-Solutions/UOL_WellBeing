<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\MessageRepository;
use App\Models\Message;
// use App\Validators\MessageValidator;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class MessageRepositoryEloquent extends BaseRepository implements
    MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $message = auth()
            ->user()
            ->messages()
            ->create($attributes);

        $message->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('messages');
        });
        return $message;
    }
}

<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ContactRepository;
use App\Models\Contact;

// use App\Validators\ContactValidator;

/**
 * Class ContactRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class ContactRepositoryEloquent extends BaseRepository implements
    ContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @return Contact
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(array $attributes): Contact
    {
        if (auth()->check()) {
            $contact = auth()
                ->user()
                ->contacts()
                ->create($attributes);
        } else {
            $contact = $this->create($attributes);
        }
        return $contact;
    }
}

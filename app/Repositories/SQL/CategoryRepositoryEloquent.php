<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\CategoryRepository;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Prettus\Repository\Events\RepositoryEntityDeleted;

// use App\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class CategoryRepositoryEloquent extends BaseRepository implements
    CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function delete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);

        if ($model->doctors()->count() != 0) {
            toast(
                __(
                    "Can't Delete This Category Because Some Doctors Have It Already You Have Remove It First",
                ),
                'error',
            );

            throw ValidationException::withMessages([
                'id' => __(
                    "Can't Delete This Category Because Some Doctors Have It Already You Have Remove It First",
                ),
            ]);
        }
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }
}

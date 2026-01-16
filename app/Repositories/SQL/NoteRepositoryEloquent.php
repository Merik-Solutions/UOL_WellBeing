<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\NoteRepository;
use App\Models\Note;
// use App\Validators\NoteValidator;

/**
 * Class NoteRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class NoteRepositoryEloquent extends BaseRepository implements NoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Note::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

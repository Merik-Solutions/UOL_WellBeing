<?php

namespace App\Repositories\interfaces;

use App\Repositories\interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoryRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface CategoryRepository extends BaseInterface
{
    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);
}

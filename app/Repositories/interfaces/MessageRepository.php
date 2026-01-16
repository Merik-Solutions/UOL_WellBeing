<?php

namespace App\Repositories\interfaces;

use App\Repositories\interfaces\BaseInterface;

/**
 * Interface MessageRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface MessageRepository extends BaseInterface
{
    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);
}

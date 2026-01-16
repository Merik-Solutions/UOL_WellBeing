<?php

namespace App\Repositories\interfaces;

use App\Models\Contact;
use App\Repositories\interfaces\BaseInterface;

/**
 * Interface ContactRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ContactRepository extends BaseInterface
{
    /**
     * @param array $attributes
     * @return Contact
     */
    public function store(array $attributes): Contact;
}

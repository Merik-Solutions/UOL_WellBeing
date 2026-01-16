<?php

namespace App\Repositories\interfaces;

use App\Repositories\interfaces\BaseInterface;

/**
 * Interface PackageRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface PackageRepository extends BaseInterface
{
    public function isActive();
}

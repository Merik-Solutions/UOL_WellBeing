<?php

namespace App\Repositories\interfaces;

use App\Models\Admin;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Http\Request;

/**
 * Interface AdminRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface AdminRepository extends BaseInterface
{
    public function store(Request $request): Admin;

    public function UpdateAdmin(Request $request, int $id): Admin;
}

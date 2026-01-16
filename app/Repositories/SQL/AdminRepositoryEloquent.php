<?php

namespace App\Repositories\SQL;

use App\Models\Attachment;
use App\Repositories\SQL\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\AdminRepository;
use App\Models\Admin;

//use App\Validators\AdminValidator;

/**
 * Class AdminRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function store(Request $request): Admin
    {
        DB::beginTransaction();
        $admin = $this->create($request->all());

        if ($request->image != null) {
            $image_data = $this->saveFile($request->file('image'), 'admins');
            $admin
                ->image()
                ->updateOrCreate(['type' => $image_data['type']], $image_data);
        }
        $role = $admin->syncRoles($request->role_id);

        DB::commit();
        return $admin->fresh();
    }

    public function UpdateAdmin(Request $request, int $id): Admin
    {
        DB::beginTransaction();
        $inputs = $request->except('password');
        if ($request->password != null) {
            $inputs['password'] = $request->password;
        }
        $admin = $this->update($inputs, $id);

        if ($request->image != null) {
            $image_data = $this->saveFile($request->file('image'), 'admins');
            $admin
                ->image()
                ->updateOrCreate(['type' => $image_data['type']], $image_data);
        }
        $role = $admin->syncRoles($request->role_id);

        DB::commit();
        return $admin->fresh();
    }
}

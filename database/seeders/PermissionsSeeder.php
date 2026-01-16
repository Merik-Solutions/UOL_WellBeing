<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_data =
        [
            'show-settings',
            'edit-settings',

            'show-contacts',
            'edit-contacts',
            'delete-contacts',

            'show-admins',
            'create-admins',
            'edit-admins',
            'delete-admins',

            'show-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            'show-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            'show-countries',
            'create-countries',
            'edit-countries',
            'delete-countries',

            'show-promoCodes',
            'create-promoCodes',
            'edit-promoCodes',
            'delete-promoCodes',

            'show-permissions',

            'show-notifications',
            'create-notifications',
            'delete-notifications',

            'show-withdrawRequests',
            'update-withdrawRequests',

            'show-refunds',
            'accept-refunds',

            'show-transactions',

            'show-dashboard',

            'show-users',
            'create-users',
            'edit-users',
            'delete-users',

            'show-patients',
            'create-patients',
            'delete-patients',
 
            'show-doctors',
            'create-doctors',
            'edit-doctors',
            'delete-doctors',
            'show-schedules',
            'create-schedules',

            'show-reservations',

            'show-packages',
            'create-packages',
            'edit-packages',
            'delete-packages',


        ];
        foreach($permission_data as $value){
            Permission::create(['name' => $value, 'guard_name' => 'admin']);
        }
        $role = Role::find(3);
        $role->givePermissionTo(Permission::all());

        // //Settings 
        // $permission = Permission::create(['name' => 'show-settings' ]);
        // $permission = Permission::create(['name' => 'edit-settings']);

        // //Contacts 
        // $permission = Permission::create(['name' => 'show-contacts']);
        // $permission = Permission::create(['name' => 'edit-contacts']);
        // $permission = Permission::create(['name' => 'delete-contacts']);

        // //Admins 
        // $permission = Permission::create(['name' => 'show-admins']);
        // $permission = Permission::create(['name' => 'create-admins']);
        // $permission = Permission::create(['name' => 'edit-admins']);
        // $permission = Permission::create(['name' => 'delete-admins']);

        // //Roles 
        // $permission = Permission::create(['name' => 'show-roles']);
        // $permission = Permission::create(['name' => 'create-roles']);
        // $permission = Permission::create(['name' => 'edit-roles']);
        // $permission = Permission::create(['name' => 'delete-roles']);
   
        // //Categories
        // $permission = Permission::create(['name' => 'show-categories']);
        // $permission = Permission::create(['name' => 'create-categories']);
        // $permission = Permission::create(['name' => 'edit-categories']);
        // $permission = Permission::create(['name' => 'delete-categories']);
      
        // //Countries
        // $permission = Permission::create(['name' => 'show-countries']);
        // $permission = Permission::create(['name' => 'create-countries']);
        // $permission = Permission::create(['name' => 'edit-countries']);
        // $permission = Permission::create(['name' => 'delete-countries']);
        
        
        // //Promocodes
        // $permission = Permission::create(['name' => 'show-promoCodes']);
        // $permission = Permission::create(['name' => 'create-promoCodes']);
        // $permission = Permission::create(['name' => 'edit-promoCodes']);
        // $permission = Permission::create(['name' => 'delete-promoCodes']);

        // //Permissions
        // $permission = Permission::create(['name' => 'show-permissions']);

        // //Notifications
        // $permission = Permission::create(['name' => 'show-notifications']);
        // $permission = Permission::create(['name' => 'create-notifications']);
        // $permission = Permission::create(['name' => 'delete-notifications']);

        // //WithDraw Requests
        // $permission = Permission::create(['name' => 'show-withdrawRequests']);
        // $permission = Permission::create(['name' => 'update-withdrawRequests']);

        
        // //Refund Requests
        // $permission = Permission::create(['name' => 'show-refunds']);
        // $permission = Permission::create(['name' => 'accept-refunds']);

        // //Transactions 
        // $permission = Permission::create(['name' => 'show-transactions']);

        
        // //Dashboard
        // $permission = Permission::create(['name' => 'show-dashboard']);


        // //User
        // Permission::create(['name' => 'show-users']);
        // Permission::create(['name' => 'create-users']);
        // Permission::create(['name' => 'edit-users']);
        // Permission::create(['name' => 'delete-users']);

        // //Patients
        // Permission::create(['name' => 'show-patients']);
        // Permission::create(['name' => 'create-patients']);
        // Permission::create(['name' => 'delete-patients']);
        
        // //Doctor
        // Permission::create(['name' => 'show-doctors']);
        // Permission::create(['name' => 'create-doctors']);
        // Permission::create(['name' => 'edit-doctors']);
        // Permission::create(['name' => 'delete-doctors']);


        // //Doctor Schedules
        // Permission::create(['name' => 'show-schedules']);
        // Permission::create(['name' => 'create-schedules']);
        // // Permission::create(['name' => 'edit-doctors']);
        // // Permission::create(['name' => 'delete-doctors']);


        

    }
}

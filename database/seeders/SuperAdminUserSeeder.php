<?php

namespace Database\Seeders;

use App\Models\Circuit;
use App\Models\CMC;
use App\Models\Organization;
use App\Models\School;
use App\Models\SchoolDistrict;
use App\Models\Subplace;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        $permissions = Permission::all();

        $user = new User();
        $user->name = "Admin";
        $user->surname = "surname";
        $user->username = "admin";
        $user->email = "schoolfurniture12@gmail.com";
        $user->organization = 1;
        $user->password = Hash::make("Admin@123");
        $user->save();

        $permission =  Organization::where('id', '=', 1)->first();
        foreach ($permission->permissions as $per) {
            $user->givePermissionTo($per);
        }

        // $role = Role::create(['name' => 'Super-Admin']);

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);  

 }
}

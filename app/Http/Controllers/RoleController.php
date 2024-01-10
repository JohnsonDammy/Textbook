<?php

namespace App\Http\Controllers;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;


class RoleController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    //
    public function index(){
        return view('furniture.Roles.Role');
    }

 
//INSERT INTO `organizations`(`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    
public function AddRole(Request $request)
{
    $RoleName = $request->input('RoleName');
    $permissions = $request->input('permission');
    
    // Convert the array of permissions to integers and then to JSON
    $permissions = array_map('intval', $permissions);
    $permissionsJson = json_encode($permissions);
    $system_id = "2";

    DB::table('organizations')->insert([
        'name' => $RoleName,
        'permissions' => $permissionsJson,
        'system_id' => $system_id,
    ]);

    $success = "Role Successfully Inserted";

    return redirect()->route('Roles')->with([
        'success' => $success,
    ]);
}
//[14,13,15,16,6,5,7,8,10,9,11,12,35,34,36,37,39,38,40,41,43,42,44,45,49,50,51,52,2,1,3,4,33,46]
//[33, 49, 50, 51, 52]
////[14, 13, 15, 16, 6, 5, 7, 8, 10, 9, 11, 12, 35, 34, 36, 37, 39, 38, 40, 41, 43, 42, 44, 45, 49, 50, 51, 52, 2, 1, 3, 4, 33, 46]

}

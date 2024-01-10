<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Organization;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\User\ManageUserRepositoryInterface;
use App\Models\RoleModels;




class EditRoleController extends Controller
{

    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private ManageUserRepositoryInterface $manageRepository;
    function __construct(ManageUserRepositoryInterface $manageRepository)
    {
        $this->manageRepository = $manageRepository;
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }


    public function index(){
     // Use the 'itrfurn' database connection for the RoleModels model
     $systemIds = [2, 3];
     $data = RoleModels::on('itrfurns')->whereIn('system_id', $systemIds)->paginate(10);
     return view('furniture.Roles.edit.editRole', compact('data'));
    }
    
    public function edit($id)
    {

    $data = Organization::find($id);
    $datas = Organization::find($id);

    $systemIds = [2, 3];
    $Organization = Organization::on('itrfurns')->whereIn('system_id', $systemIds)->paginate(10);

    $schools = School::get();

    // Retrieve the User model instance with the 'itrfurn' connection
    $user = User::on('itrfurns')->find($id);

    if ($user && $user->organization != '2') {
        $user->username = null;
    }

    $permissions = DB::connection('itrfurns')->table("model_has_permissions")->where('model_id', $id)->get('permission_id');
    $per = [];

    foreach ($permissions as $p) {
        array_push($per, $p->permission_id);
    }

    return view('furniture.Roles.edit.EditNewRole', compact('user', 'data', 'schools', 'per', 'datas', 'Organization'));

}


    public function update(Request $request)
{
    $RoleName = $request->input('name');
    $permissions = $request->input('permission');
    $RoleId = $request->input('RoleID');

    // Convert the array of permissions to integers and then to JSON
    $permissions = array_map('intval', $permissions);
    $permissionsJson = json_encode($permissions);

    // Use the `connection` method to specify the 'itrfurn' connection and update the record
    DB::connection('itrfurns')
        ->table('organizations')
        ->where('id', $RoleId)
        ->update([
            'name' => $RoleName,
            'permissions' => $permissionsJson,
        ]);

    $success = "Role Successfully Updated";

    return redirect()->route('editRoless')->with([
        'successa' => $success,
    ]);
}

}

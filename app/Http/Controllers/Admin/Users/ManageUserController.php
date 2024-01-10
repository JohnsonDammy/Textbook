<?php

namespace App\Http\Controllers\Admin\Users;

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

class ManageUserController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\
     * 
     */
    /*
     return [
            "status" => true,
            "message" => "The user profile has been created successfully",
            "data" => ["users" => $data, "org" => $organization],
            "status_code" => 200
        ];
    */
    public function index()
    {
        $data = $this->manageRepository->getAllUser();

        return view('furniture.users.list', ['data' => $data,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $systemIds = [2, 3];

        // Retrieve organizations where system_id is 2 using the 'itrfurn' connection
        $data = Organization::on('itrfurns')->whereIn('system_id', $systemIds)->get();
        $Organization = Organization::on('itrfurns')->whereIn('system_id', $systemIds)->get();
    
        $schools = School::on('itrfurns')->get();
        return view('furniture.users.add', compact('data', 'schools', 'Organization'));
    }
    

    /**
     * 
     * 
     *Error - Adding a new user failed. SQLSTATE[42S22]: Column not found: 1054 Unknown column 'District_Id' in 'field list' (SQL: insert into `users` (`name`, `email`, `District_Id`, `username`, `surname`, `system_id`, `organization`, `updated_at`, `created_at`) values (BLACKBANK PRIMARY SCHOOL, johnsondammy9558@gmail.com, ?, 500110445, ?, 2, 2, 2023-10-25 20:28:56, 2023-10-25 20:28:56))




     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if ($request->validated()) {
            // Use the 'itrfurn' connection for this operation
            DB::connection('itrfurns')->beginTransaction();
            try {
                $data = $this->manageRepository->addUser($request);
                // Commit the transaction
                DB::connection('itrfurns')->commit();
            } catch (\Throwable $th) {
                // Roll back the transaction on error
                DB::connection('itrfurns')->rollBack();
                return back()
                    ->with('error', 'Error - Adding a new user failed. ' . $th->getMessage())
                    ->withInput()
                    ->with('permission', request('permission'));
            }
            return redirect()->route('users.index')
                ->with('success', "User profile created successfully!");
        }
    }
    
    
    
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $systemIds = [2, 3];
    
        // Retrieve organizations where system_id is 2
        $data = Organization::whereIn('system_id', $systemIds)->get();
        $Organization = Organization::whereIn('system_id', $systemIds)->get();
    
        $schools = School::on('itrfurns')->get();
        $user = User::on('itrfurns')->find($id);
    
        if ($user->organization != '2') {
            $user->username = null;
        }
    
        $permissions = DB::table("model_has_permissions")
            ->where('model_id', $id)
            ->get('permission_id');
        
        $per = [];
        foreach ($permissions as $p) {
            array_push($per, $p->permission_id);
        }
    
        return view('furniture.users.edit', compact('user', 'data', 'schools', 'per', 'Organization'));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if ($request->validated()) {
            try {
                $data = $this->manageRepository->updateUser($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating user failed. ' . $th->getMessage())->withInput();
            }
            return redirect()->route('users.index')
                ->with('success', "The user profile has been updated successfully!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::on('itrfurns')->find($id); // Set the connection here
    
        if (!$user) {
            return back()->with('error', "User not found with id : $id");
        }
    
        try {
            $data = $this->manageRepository->deleteUser($id);
            if ($data == null) {
                return back()->with('alert', 'User cannot be deleted as the furniture replacement process is in progress.');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Error - Deleting user failed. ' . $th->getMessage());
        }
    
        return redirect()->route('users.index')
            ->with('success', "The user profile has been deleted successfully!");
    }
    


    public function schoolsearch(Request $request)
    {
        $schools = School::on('itrfurns')->where('name', 'like', '%' . $request->search . '%')->get();
        return response()->json(['status' => 200, 'data' => $schools]);
    }
    
    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            // Set the database connection before querying the data
            $data = User::on('itrfurns')
                ->where('name', 'like', '%' . $request->input('query') . '%')
                ->orWhere('username', 'like', '%' . $request->input('query') . '%')
                ->orWhere('surname', 'like', '%' . $request->input('query') . '%')
                ->paginate(10)
                ->withQueryString();
    
            if (count($data) > 0) {
                return view('furniture.users.list', ['data' => $data]);
            }
    
            return redirect()->route('users.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
    
    
}

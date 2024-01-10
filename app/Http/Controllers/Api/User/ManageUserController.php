<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\User\ManageUserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class ManageUserController extends Controller
{
    /*
     *  Accessing Manage User Repository  
    */
    private ManageUserRepositoryInterface $manageRepository;

    function __construct(ManageUserRepositoryInterface $manageRepository)
    {
        $this->manageRepository = $manageRepository;

        /*
         *  Middlewares for user permissions
         *   
        */
        $this->middleware('api_permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('api_permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:user-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:user-delete', ['only' => ['destroy']]);
    }

    /*
    * Response will be fixed for both api and web
    * Response Pattern:
    * [
        "status"=>true/false,
        "message"=>"Some message"
        "data"=>"whether it will be exception fields or on success it will be user details or something else ",
        "status_code"=>"status code for the api/web"
       ]
    */

    /**
     * Display a listing of All User 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->manageRepository->getAllUser();
            $list = [];
            if (count($data) > 0) {
                if (!Request::input("all")) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                        "total_page" => $data->lastPage(),
                        "total_records" => $data->total(),
                        "current_records" => $data->count()
                    ];
                }
                foreach ($data as $key => $item) {
                    $list["records"][$key] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "User  list." : "NO Data Found", "data" => $list], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    /**
     * Store a newly created User in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $this->manageRepository->addUser($request);
        } catch (\Throwable $th) {
            //returning response when having inernal server error
            return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "User added succuessfully !" : "Unable to add user please try again !", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified User with help of user id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->manageRepository->getSingleUser($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "User  detaisl." : "NO Data Found", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found with id : $id", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->manageRepository->updateUser($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "User  Updated successfully !." : "Unable to update user . Please try again !", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified User from storage with the help of user id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->manageRepository->deleteUser($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "User  deleted successfully !." : "Unable to delete user. User having assigned Collection requests!", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    /**
     * Search user with help of username , surname or name.
     *
     * @param  int  $query
     * @return \Illuminate\Http\Response
     */

    public function userSearch(SearchRequest $request)
    {
        try {
            $data = $this->manageRepository->searchUser($request->input('query'));
            $list = [];
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $list[] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $list ? "User Search details." : "Your search did not match any records", "data" => $list], $list ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    protected  function list(object $user)
    {
        // storing permissions of the user
        $permission = [];
        foreach ($user->getDirectPermissions() as $item) {
            $permission[] = [
                "id" => $item->id,
                "name" => $item->name
            ];
        }

        return [
            "id" => $user->id,
            "name" => $user->name,
            "surname" => $user->surname,
            "username" => $user->username,
            "email" => $user->email,
            "organization_id" => $user->organization,
            "organization" => $user->getOrganization->name,
            "created_at" => $user->created_at,
            "permissions" => $permission
        ];
    }
}

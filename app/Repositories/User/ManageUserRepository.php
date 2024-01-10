<?php

namespace App\Repositories\User;

use App\Interfaces\User\ManageUserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Helpers\SendEmail;
use App\Models\CollectionRequest;
use App\Models\RequestStatus;

class ManageUserRepository implements ManageUserRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    //manage user get all user list
    // Manage user get all user list
    public function getAllUser()
    {
        $data = DB::connection($this->connection)
            ->table('users')
            ->orderBy('surname')
            ->orderBy('name')
            ->paginate(10);
        
        if (Request::input("all")) {
            $data = DB::connection($this->connection)
                ->table('users')
                ->orderBy('surname')
                .orderBy('name')
                ->get();
        }

        return $data;
    }


// Manage user get single user
    public function getSingleUser($id)
    {
        return DB::connection($this->connection)
            ->table('users')
            ->where('id', $id)
            ->first();
    }

    //manage user delete user
    // Manage user delete user
    public function deleteUser($id)
    {
        $requests =  DB::connection($this->connection)
            ->table('collection_requests')
            ->where("user_id", $id)
            ->where('status_id', '<', RequestStatus::DELIVERY_CONFIRMED)
            ->get();
        
        if (count($requests) == 0) {
            $user = DB::connection($this->connection)
                ->table('users')
                ->where('id', $id)
                ->first();
            
            if ($user) {
                DB::connection($this->connection)
                    ->table('users')
                    ->where('id', $id)
                    ->delete();
            }
            
            return $user;
        }

        return null;
    }
    //manage user add user
    public function addUser(object $request)
    {
//     Error - Adding a new user failed. SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'District_Id' cannot be null (SQL: insert into `users` (`name`, `email`, `District_Id`, `surname`, `username`, `system_id`, `organization`, `updated_at`, `created_at`) values (Pinetown, johnsondammy98@gmail.com, ?, Pine Officer, pinetown.pineofficer, 2, 3, 2023-10-25 20:41:06, 2023-10-25 20:41:06))
//Error - Adding a new user failed. SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`itrfurns`.`model_has_permissions`, CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE) (SQL: insert into `model_has_permissions` (`model_id`, `model_type`, `permission_id`) values (17, App\Models\User, 49))



        $user = null;
        DB::beginTransaction();
        try {
            $user = new User();
            $user->setConnection('itrfurns'); // Set the connection for the User model
            $user->name = $request->name;
            $user->email = $request->email;
            $user->District_Id = $request->district_id;

            if ($request->organization == 2) {
                $user->username = $request->emis;
                $user->system_id = "3";

                $user->surname = null;
            } else {
                $user->surname = $request->surname;
                $username = $this->username($request);
                $user->username = $username;
                $user->District_Id = $request->district_id;
                $user->system_id = "2";


            }
            $user->organization = $request->organization;
            $user->District_Id = $request->district_id;
         //   $user->system_id = "2";


            $user->save();
            foreach ($request->permission as $per) {
                $user->givePermissionTo($per);
            }

            //sening mail to user while creating the profile
            SendEmail::SetNewPassword($user);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $user = null;
            throw $th;
        }

        return $user;
    }
    //manage user update
    public function updateUser(object $request, $id)
    {
        $user = User::find($id);
        DB::beginTransaction();
        try {
            if ($user->name != $request->name || $user->surname != $request->surname) {
                $username = self::username($request);
                $user->username = $username;
                $user->system_id = "2";

            }
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->organization == 2) {
                $user->username = $request->emis;
                $user->surname = null;
                $user->system_id = "3";

            } else {
                $user->surname = $request->surname;
              //  $user->system_id = "2";

            }
            $user->organization = $request->organization;
            $user->update();
            DB::table("model_has_permissions")->where('model_id', $id)->delete();
            foreach ($request->permission as $per) {
                $user->givePermissionTo($per);
            }
            //commiting when successfully stored
            SendEmail::UserProfileUpdate($user);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $user = null;
            throw $th;
        }

        return $user;
    }
    //manage user search
    public function searchUser($query)
    {
        // $user = User::where('name', 'like', '%' . $query . '%')
        //     ->orWhere('username', 'like', '%' . $query . '%')
        //     ->orWhere('surname', 'like', '%' . $query . '%')
        //     ->paginate(10)
        //     ->withQueryString();
        // if (Request::capture()->is('api/*')) {
        //     $user = User::where('name', 'like', '%' . $query . '%')
        //         ->orWhere('username', 'like', '%' . $query . '%')
        //         ->orWhere('surname', 'like', '%' . $query . '%')
        //         ->get();
        // }
        // return $user;

        $user = User::on('itrfurns')
        ->where('name', 'like', '%' . $query . '%')
        ->orWhere('username', 'like', '%' . $query . '%')
        ->orWhere('surname', 'like', '%' . $query . '%')
        ->paginate(10);

    if (Request::capture()->is('api/*')) {
        $user = User::on('itrfurns')
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('username', 'like', '%' . $query . '%')
            ->orWhere('surname', 'like', '%' . $query . '%')
            ->get();
    }

    return $user;

    }


    //generate a username
    public static function username($request)
    {
        $user = User::withTrashed()->where('name', '=', $request->name)->where('surname', '=', $request->surname)->get();
        $count = count($user);
        $name = preg_replace('/\s+/', '', $request->name);
        $surname = preg_replace('/\s+/', '', $request->surname);
        if ($count > 0) {
            $username = strtolower($name) . '.' . strtolower($surname) . $count;
            return ($username);
        } else {
            $username = strtolower($name) . '.' . strtolower($surname);
            return ($username);
        }
    }
}

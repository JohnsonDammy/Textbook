<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $connection = 'itrfurn';

    //User login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
        ]);

        // validating details
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'data' => $validator->errors(), 'status' => 422], 422);
        }

        try {
            // getting user details whether registtered or not
            $user = User::on('itrfurn')->where('username', $request->input('username'))->get()->first();
            //checking user is exist or not

            if ($user) {
                // checking whether user passwrd set or not 
                if (!$user->password) {
                    return response()->json(['message' => 'Access Denied : Password is not set', 'data' => "Please set new password,reset link is already sent on your mail.Please try by forget password", 'status' => 401], 401);
                }
                // checking status of the user
                if ($user->status == 1) {
                    // attempting login request
                    if (!$token = auth("api")->attempt($validator->validated())) {
                        //after unseccessfull attempt changing the states of status and attempts feilds in database
                        $user->attempts += 1;
                        $user->status = $user->attempts >= 4 ? 0 : 1;
                        $user->update();

                        //blocking the user on 4th unseccussfull attempt
                        if ($user->attempts == 4) {
                            return response()->json(['message' => 'Access Denied', 'data' => "The account for this username has been locked.Please contact to System Admin or try by password resetting", 'status' => 401], 401);
                        }
                        return response()->json(['message' => 'Invalid credentials', 'data' => ["message" => "Invalid email id or password", "attempts" => 4 - $user->attempts], 'status' => 401], 401);
                    }
                    //after successfull attempt changing state of attempts
                    $user->attempts = 0;
                    $user->update();

                    // getting user details roles and permisions of the user 

                    $auth = auth("api")->user();
                    $authuser = [
                        "id" => $auth->id,
                        "name" => $auth->name,
                        "surname" => $auth->surname,
                        "username" => $auth->username,
                        "email" => $auth->email,
                        "status" => $auth->status,
                        "attempts" => $auth->attempts,
                        "organization" => $auth->getOrganization->name,
                        "organization_id" => $auth->getOrganization->id,
                        "created_at" => $auth->created_at,
                        "username" => $auth->username,
                        "District_Id" => $auth->District_Id,

                    ];

                    // storing permissions of the user
                    $permission = [];
                    foreach (auth("api")->user()->getDirectPermissions() as $item) {
                        $permission[] = [
                            "id" => $item->id,
                            "name" => $item->name
                        ];
                    }

                    return $this->respondWithToken($token, $permission, $authuser);
                }
                // returing the response while user is blocked
                return response()->json(['message' => 'Access Denied', 'data' => "The account for this username has been locked. Please contact to System Admin or try by password resetting", 'status' => 401], 401);
            }
            // returning response while email is not registered
            return response()->json(['message' => 'Invalid credentials', 'data' => "Please enter valid username and password, please try again", 'status' => 401], 401);
        } catch (\Throwable $th) {
            //returning response when having inernal server error
            return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    // User logout
    public function logout()
    {
        // logging out authenticated user
        if (auth('api')->user()) {
            auth()->guard('api')->logout();
        }

        return response()->json(['message' => 'User successfully logged out.', 'data' => '', 'status' => 200], 200);
    }


    // User change Password
    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'old_password' => ['required'],
            'confirmed_password' => ['required'],
            'new_password' => ['required', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/', 'same:confirmed_password'],
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => 'Validation error.', 'data' => $validate->errors(), 'status' => 422], 422);
        }

        // verifyng the password whether old password and current password does match
        if (password_verify($request->input('old_password'), auth("api")->user()->password)) {
            try {
                // getting user details of authenticated user
                $user = User::find(auth("api")->user()->id);
                $user->password = Hash::make($request->input('new_password'));
                $user->update();
                //returning the response after changing password
                return response()->json(['message' => 'New Password created successfully !', 'data' => '', 'status' => 200], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], 500);
            }
        }
        // returning response while password does not match with current password
        return response()->json(['message' => 'Password does not match', 'data' => 'Old password and new password does not match', 'status' => 403], 403);
    }

    // Function for Forget Password
    public function forgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "username" => ['required']
        ], [
            "username.required" => " Please enter Username"
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => 'Validation error.', 'data' => $validate->errors(), 'status' => 422], 422);
        }

        try {
            // checking whether email is registered or not 
            $user = User::where('username', $request->input('username'))->get()->first();
            if ($user) {
                $status = Password::sendResetLink(
                    ["email" => $user->email]
                );

                if ($status === Password::RESET_LINK_SENT) {
                    return response()->json(['message' => 'Link send successfully on email', 'data' => $user->email, 'status' => 200], 200);
                }
                if ($status == 'passwords.throttled') {
                    return response()->json(['message' => 'Already send the reset link', 'data' => $status, 'status' => 403], 403);
                }
                return response()->json(['message' => 'Can not sent the reset link.Please try again', 'data' => $status, 'status' => 500], 500);
            }
            return response()->json(['message' => 'The entered username is not registered', 'data' => '', 'status' => 403], 403);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    // function for returning json data with token 
    protected function respondWithToken($token, $permission = null, $user = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60,
            'status' => 200,
            'data' => [
                'user' => $user,
                'permissions' => $permission
            ]
        ], 200);
    }
}

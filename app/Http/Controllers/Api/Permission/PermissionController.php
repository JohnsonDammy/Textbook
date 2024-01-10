<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $permission = Permission::all();
            $list = [];
            foreach ($permission as $item) {
                //generating list 
                $list[] = $this->list($item);
            }
            return response()->json(["message" => "", "data" => $list]);
        } catch (\Throwable $th) {
            //returning response when having inernal server error
            return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    // list of permissions
    protected function list($permission)
    {
        return [
            "id" => $permission->id,
            "name" => $permission->name
        ];
    }
}

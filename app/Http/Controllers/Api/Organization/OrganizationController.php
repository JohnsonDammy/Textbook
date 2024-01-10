<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orgnization = Organization::all();
            $list = [];
            if ($orgnization) {
                if (count($orgnization) > 0) {
                    foreach ($orgnization as $item) {
                        $list[] = $this->list($item);
                    }
                    return response()->json(['message' => "list of organization", 'data' => $list]);
                }
            }
            return response()->json("No organization found", 404);
        } catch (\Throwable $th) {
            //returning response when having inernal server error
            return response()->json(['message' => 'Internal server error', 'data' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    // list of organization details
    protected function list($orgnization)
    {
        return [
            "id" => $orgnization->id,
            "name" => $orgnization->name,
            "permissons" => $orgnization->permissions,
        ];
    }
}

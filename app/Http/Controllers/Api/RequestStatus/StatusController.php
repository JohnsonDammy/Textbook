<?php

namespace App\Http\Controllers\Api\RequestStatus;

use App\Http\Controllers\Controller;
use App\Models\RequestStatus;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    // getting all request status 
    public function getAllStatus()
    {
        try {
            $list = [];
            $data = RequestStatus::all();
            if ($data) {
                foreach ($data as $item) {
                    $list[] = [
                        "id" => $item->id,
                        "name" => $item->name
                    ];
                }
                return response()->json(["message" => "Status list", "data" => $list], Response::HTTP_OK);
            }
            return response()->json(["message" => "No status list found", "data" => []], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal server error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

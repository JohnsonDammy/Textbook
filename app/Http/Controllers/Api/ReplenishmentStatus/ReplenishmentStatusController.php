<?php

namespace App\Http\Controllers\Api\ReplenishmentStatus;

use App\Http\Controllers\Controller;
use App\Models\ReplenishmentStatus;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplenishmentStatusController extends Controller
{
    // getting replenishment status
    public function getreplenishmentstatus()
    {
        try {
            $list = [];
            $data = ReplenishmentStatus::all();
            if ($data) {
                foreach ($data as $item) {
                    if (Request::input("all") == 'true') {
                        $list[] = [
                            "id" => $item->id,
                            "name" => $item->name
                        ];
                    } else {
                        if ($item->id != ReplenishmentStatus::PENDING) {
                            $list[] = [
                                "id" => $item->id,
                                "name" => $item->name
                            ];
                        }
                    }
                }
                return response()->json(["message" => "Status list", "data" => $list], Response::HTTP_OK);
            }
            return response()->json(["message" => "No status list found", "data" => []], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal server error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

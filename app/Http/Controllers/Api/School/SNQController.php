<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolSnq;
use Symfony\Component\HttpFoundation\Response;

class SNQController extends Controller
{
    /**
     * Getting all list of School SNQ
     */
    public function getAllSNQ()
    {
        $list = [];
        $data = SchoolSnq::all();
        if ($data) {
            if (count($data)  > 0) {
                foreach ($data as $key => $value) {
                    $list[] = [
                        "id" => $value->id,
                        "name" => $value->name
                    ];
                }
                return response()->json(["message" => "School snq list", "data" => $list], Response::HTTP_OK);
            }
        }
        return response()->json(["message" => "No data found", "data" => null], Response::HTTP_NOT_FOUND);
    }
}

<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use Symfony\Component\HttpFoundation\Response;

class SchoolLevelController extends Controller
{
    /**
     * Getting all list of School LEVEL
     */
    public function getAllLevel()
    {
        $list = [];
        $data = SchoolLevel::all();
        if ($data) {
            if (count($data)  > 0) {
                foreach ($data as $key => $value) {
                    $list[] = [
                        "id" => $value->id,
                        "name" => $value->name
                    ];
                }
                return response()->json(["message" => "School level list", "data" => $list], Response::HTTP_OK);
            }
        }
        return response()->json(["message" => "No data found", "data" => null], Response::HTTP_NOT_FOUND);
    }
}

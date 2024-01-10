<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\StoreDistrictRequest;
use App\Http\Requests\District\UpdateDistrictRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolLocation\DistrictRepositoryInterface;
use App\Models\SchoolDistrict;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolDistrictController extends Controller
{

    private DistrictRepositoryInterface $districtRepository;

    public function __construct(DistrictRepositoryInterface $districtRepository)
    {
        $this->districtRepository = $districtRepository;

        $this->middleware('api_permission:district-list|district-create|district-edit|district-delete', ['only' => ['index', 'store']]);
        $this->middleware('api_permission:district-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:district-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:district-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        try {
            $data =  $this->districtRepository->getAllDistrict();
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
            return response()->json(['message' => "Internal Server Error", 'data' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => count($data) > 0 ? "District List" : "No data found", 'data' => $list], count($data) > 0 ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
        try {
            $data = $this->districtRepository->addDistrict($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => "New district added successfully!", 'data' => $data ? $this->list($data) : ''], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->districtRepository->getSingleDistrict($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? $this->list($data) : "District Not found", 'data' => $data ? $this->list($data) : ''], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, $id)
    {
        $district = SchoolDistrict::find($id);
        if (!$district) {
            return response()->json(["message" => "District not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->districtRepository->updateDistrict($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "District Updated Successfully !" : "Unable to update District", 'data' => $data ? $this->list($data) : '', $data ?  Response::HTTP_ACCEPTED : Response::HTTP_FORBIDDEN]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $district = SchoolDistrict::find($id);
        if (!$district) {
            return response()->json(["message" => "District not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {

            $data = $this->districtRepository->deleteDistrict($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "District Deleted Successfully !" : "This district have attatched CMC", 'data' => $data ? $this->list($data) : ''], $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    //getting all district 
    public function getAllDistrict()
    {
        try {
            $data  = SchoolDistrict::all();
            $list = [];
            if ($data) {
                if (count($data) > 0) {
                    foreach ($data as $key => $value) {
                        $list[] =  [
                            "id" => $value->id,
                            "district_office" => ucwords($value->district_office),
                        ];
                    }
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => "Internal Server Error", 'data' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => count($data) > 0 ? "District List" : "No data found", 'data' => $list], count($data) > 0 ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    //Search district by name
    public function search(SearchRequest $request)
    {
        try {
            $data = $this->districtRepository->searchDistrict($request->input('query'));
            if (count($data) == 0) {
                return response()->json(["message" => "Your search did not match any records", "data" => ""], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $list = [];
        foreach ($data as $item) {
            $list[] = $this->list($item);
        }
        return response()->json(['message' => "District List", 'data' => $list], Response::HTTP_OK);
    }

    protected function list($district)
    {
        return [
            "id" => $district->id,
            "district_office" => ucwords($district->district_office),
            "cmc_list" => $this->cmcList($district->getCMCDetails)
        ];
    }

    protected  function cmcList($cmc = null)
    {
        $list = [];
        if ($cmc) {
            foreach ($cmc as $item) {
                $list[] = [
                    "cmc_id" => $item->id,
                    "cmc_name" => $item->cmc_name
                ];
            }
        }
        return $list;
    }
}

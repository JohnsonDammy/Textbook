<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMC\StoreCMCRequest;
use App\Http\Requests\CMC\UpdateCMCRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolLocation\CMCRepositoryInterface;
use App\Models\CMC;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolCMCController extends Controller
{
    private  CMCRepositoryInterface $schoolCMCRepo;
    public function __construct(CMCRepositoryInterface $schoolCMCRepo)
    {
        $this->schoolCMCRepo = $schoolCMCRepo;
        $this->middleware('api_permission:cmc-list|cmc-create|cmc-edit|cmc-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('api_permission:cmc-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:cmc-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:cmc-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->schoolCMCRepo->getAllCMC();
            $list = [];
            if ($data) {
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
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => count($data) > 0 ? "CMC List" : "No Data Found", 'data' => $list], count($data) > 0 ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCMCRequest $request)
    {
        try {
            $data = $this->schoolCMCRepo->storeCMC($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "CMC added successfully!" : "Invalid Request please try again!", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_CREATED : Response::HTTP_FORBIDDEN);
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
            $data = $this->schoolCMCRepo->getSingleCMC($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "CMC Details!" : "CMC not found", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCMCRequest $request, $id)
    {
        try {
            $data = $this->schoolCMCRepo->updateCMC($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "CMC updated successfully!" : "CMC not found", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_ACCEPTED : Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cmc = CMC::find($id);
        if (!$cmc) {
            return response()->json(["message" => "No CMC details found!", "data" => null], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->schoolCMCRepo->deleteCMC($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "CMC deleted successfully!" : "CMC can not be deleted", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $this->schoolCMCRepo->searchCMC($request->input('query'));
            if ($data) {
                if (count($data) > 0) {
                    $list = [];
                    foreach ($data as $item) {
                        $list[] = $this->list($item);
                    }
                    return response()->json(["message" => "Search list", "data" => $list], Response::HTTP_OK);
                }
            }
            return response()->json(["message" => "Your search did not match any records", "data" => null], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    protected function list(object $cmc)
    {
        return [
            "id" => $cmc->id,
            "cmc_name" => ucwords($cmc->cmc_name),
            "district_id" => $cmc->getDistrictDetails->id,
            "district_office" => ucfirst($cmc->getDistrictDetails->district_office),
            "circuit_list" => $this->circuitList($cmc->getCircuitDetails)
        ];
    }

    protected function circuitList($circuit = null)
    {
        $list = [];
        if ($circuit) {
            foreach ($circuit as $item) {
                $list[] = [
                    "id" => $item->id,
                    "circuit_name" => $item->circuit_name
                ];
            }
        }
        return $list;
    }
}

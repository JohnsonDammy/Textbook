<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Circuit\StoreCircuitRequest;
use App\Http\Requests\Circuit\UpdateCircuitRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolLocation\CircuitRepositoryInterface;
use App\Models\Circuit;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolCircuitController extends Controller
{
    private  CircuitRepositoryInterface $schoolCircuitRepo;
    public function __construct(CircuitRepositoryInterface $schoolCircuitRepo)
    {
        $this->schoolCircuitRepo = $schoolCircuitRepo;
        $this->middleware('api_permission:circuit-list|circuit-create|circuit-edit|circuit-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('api_permission:circuit-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:circuit-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:circuit-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the All circuits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->schoolCircuitRepo->getAllCircuits();
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
        return response()->json(['message' => count($data) ? "Circuit List" : "No Data Found", 'data' => $list], count($data) ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCircuitRequest $request)
    {
        try {
            $data = $this->schoolCircuitRepo->addCircuit($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Circuit details" : "Invalid Request please try again!", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_CREATED : Response::HTTP_FORBIDDEN);
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
            $data = $this->schoolCircuitRepo->getSingleCircuit($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Circuit Details!" : "Circuit not found", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCircuitRequest $request, $id)
    {
        try {
            $data = $this->schoolCircuitRepo->updateCircuit($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Circuit updated successfully!" : "Circuit not found", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_ACCEPTED : Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $circuit = Circuit::find($id);
        if (!$circuit) {
            return response()->json(["message" => "No Circuit details found!", "data" => null], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->schoolCircuitRepo->deleteCircuit($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Circuit deleted successfully!" : "Circuit can not be deleted", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $this->schoolCircuitRepo->searchCircuit($request->input('query'));
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
    protected function list(object $circuit)
    {
        return [
            "id" => $circuit->id,
            "circuit_name" => ucwords($circuit->circuit_name),
            "cmc_id" => $circuit->getCmcDetails ?  $circuit->getCmcDetails->id : null,
            "cmc_name" => $circuit->getCmcDetails ? ucfirst($circuit->getCmcDetails->cmc_name) : null,
            "subplace_list" => $this->subplaceList($circuit->getSubplaceDetails)
        ];
    }

    protected function subplaceList($subplace = null)
    {
        $list = [];
        if ($subplace) {
            foreach ($subplace as $item) {
                $list[] = [
                    "id" => $item->id,
                    "subplace_name" => $item->subplace_name
                ];
            }
        }
        return $list;
    }
}

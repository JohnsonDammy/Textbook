<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Subplace\StoreSubplaceRequest;
use App\Http\Requests\Subplace\UpdateSubplaceRequest;
use App\Models\Subplace;
use App\Repositories\SchoolLocation\SubplaceRepository;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolSubplaceController extends Controller
{
    private  SubplaceRepository $schoolSubplaceRepo;
    public function __construct(SubplaceRepository $schoolSubplaceRepo)
    {
        $this->schoolSubplaceRepo = $schoolSubplaceRepo;
        $this->middleware('api_permission:subplace-list|subplace-create|subplace-edit|subplace-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('api_permission:subplace-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:subplace-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:subplace-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->schoolSubplaceRepo->getAllSubplaces();
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
        return response()->json(['message' => $data ? "Circuit List" : "No Data Found", 'data' => $list], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubplaceRequest $request)
    {
        try {
            $data = $this->schoolSubplaceRepo->storeSubplace($request);
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
            $data = $this->schoolSubplaceRepo->getSingleSubplace($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Circuit Details!" : "Circuit not found", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubplaceRequest $request, $id)
    {
        try {
            $data = $this->schoolSubplaceRepo->updateSubplace($request, $id);
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
        $subplace = Subplace::find($id);
        if (!$subplace) {
            return response()->json(["message" => "No subplace details found!", "data" => null], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->schoolSubplaceRepo->deleteSubplace($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "Subplace deleted successfully!" : "Subplace can not be deleted", 'data' => $data ? $this->list($data) : null], $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $this->schoolSubplaceRepo->searchSubplace($request->input('query'));
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
    protected function list(object $subplace)
    {
        return [
            "id" => $subplace->id,
            "subplace_name" => ucwords($subplace->subplace_name),
            "circuit_id" =>  $subplace->getCircuitDetails->id,
            "circuit_name" => ucfirst($subplace->getCircuitDetails->circuit_name)
        ];
    }
}

<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Requests\School\StoreSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Requests\SearchRequest;
use App\Models\SchoolDistrict;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolController extends Controller
{
    private SchoolRepositoryInterface $schoolRepository;

    function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;

        $this->middleware('api_permission:school-list|school-create|school-edit|school-delete', ['only' => ['index', 'store']]);
        $this->middleware('api_permission:school-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:school-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:school-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Getting list of all colleges
    public function index()
    {
        try {
            $data =  $this->schoolRepository->getAllSchool();
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
        return response()->json(['message' => "School list", 'data' => $list], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    /**
     * Store a newly created resource in storage.
     * Storing the data in database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolRequest $request)
    {
        if (!SchoolDistrict::find($request->district_id)) {

            return response()->json(["message" => "District not found with id : $request->district_id"], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->schoolRepository->addSchool($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => "New school added successfully!", 'data' => $data ? $this->list($data) : ''], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->schoolRepository->getSingleSchool($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "School details" : 'School details not found !', 'data' => $data ? $this->list($data) : ''], $data ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        $district = SchoolDistrict::find($request->district_id);
        $school = School::find($id);
        if (!$district) {
            return response()->json(["message" => "District not found with id : $request->district_id"], Response::HTTP_NOT_FOUND);
        }
        if (!$school) {
            return response()->json(["message" => "School not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->schoolRepository->updateSchool($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "School updated successfully!" : "Updating school failed", 'data' => $data ? $this->list($data) : '', $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);
        if (!$school) {
            return response()->json(["message" => "School not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $users = User::where('username', $school->emis)->get();
            if (count($users) > 0) {
                return response()->json(["message" => "Cannot delete school", "data" => "School cannot be deleted as user is assigned to it."], Response::HTTP_FORBIDDEN);
            }

            $data = $this->schoolRepository->deleteSchool($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => $data ? "School deleted successfully!" : "Deleting school failed.", 'data' => $data ? $this->list($data) : '', $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN]);
    }

    // school search by name or EMIS number
    public function schoolSerach(SearchRequest $request)
    {
        try {
            $data = $this->schoolRepository->searchSchool($request->input('query'));
            if (count($data) == 0) {
                return response()->json(["message" => "Your search did not match any records.", "data" => ""], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $list = [];
        foreach ($data as $item) {
            $list[] = $this->list($item);
        }
        return response()->json(['message' => "School list", 'data' => $list], Response::HTTP_OK);
    }

    //creating list
    protected function list($school)
    {
        return [
            "id" => $school->id,
            "name" => $school->name,
            "emis" => $school->emis,
            "school_principal" => $school->school_principal,
            "tel" => $school->tel,
            "district_id" => $school->district_id,
            "district_name" => $school->getDistrict ? $school->getDistrict->district_office : null,
            "cmc_id" => $school->cmc_id,
            "cmc_name" => $school->getCMC ? ucwords($school->getCMC->cmc_name) : null,
            "circuit_id" => $school->circuit_id,
            "circuit_name" => $school->getCircuit ? ucwords($school->getCircuit->circuit_name) : null,
            "subplace_id" => $school->subplace_id,
            "subplace_name" => $school->getSubplace ? ucwords($school->getSubplace->subplace_name) : null,
            "snq_id" => $school->snq_id,
            "level_id" => $school->level_id,
            "street_code" => $school->street_code,

        ];
    }
}

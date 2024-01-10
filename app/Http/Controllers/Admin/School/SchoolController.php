<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\School\StoreSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolRepositoryInterface;
use App\Models\Circuit;
use App\Models\CMC;
use App\Models\CollectionRequest;
use App\Models\Subplace;

class SchoolController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private SchoolRepositoryInterface $schoolRepository;

    function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;

        $this->middleware('permission:school-list|school-create|school-edit|school-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:school-create', ['only' => ['create', 'store', 'getcmclist', 'getcircuitlist', 'getsubplacelist']]);
        $this->middleware('permission:school-edit', ['only' => ['edit', 'update', 'getcmclist', 'getcircuitlist', 'getsubplacelist']]);
        $this->middleware('permission:school-delete', ['only' => ['destroy']]);
        $this->middleware('permission:school-list|district-list|cmc-list|circuit-list|subplace-list', ['only' => ['schoolmaintenance']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->schoolRepository->getAllSchool();
        return view('furniture.maintenance.school.school.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.school.school.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if ($request->validated()) {
            try {
                $data = $this->schoolRepository->addSchool($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new school failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('school.index')
                    ->with('success', 'New school added successfully!');
            }
            return back()->with('error', 'Adding new school failed.')->withInput();
      //  }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::find($id);
        return view('furniture.maintenance.school.school.edit', ['school' => $school]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // if ($request->validated()) {
            try {
                $data = $this->schoolRepository->updateSchool($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating school failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('school.index')
                    ->with('success', 'School updated successfully!');
            }
            return back()->with('error', 'Updating school failed.')->withInput();
      //  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);
        // $users = User::where('username', $school->emis)->get();
        // if (count($users) > 0) {
        //     return back()->with('alert', 'School cannot be deleted as user is assigned to it.');
        // }
        try {
            $data = $this->schoolRepository->deleteSchool($id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error - Deleting school failed. ' . $th->getMessage());
        }
        if ($data) {
            return back()->with('success', 'School deleted successfully!');
        }
        return back()->with('error', 'Deleting school failed.');
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->schoolRepository->searchSchool($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.school.school.list', ['data' => $data]);
            }
            return redirect()->route('school.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }

    public function schoolmaintenance()
    {
        return view('furniture.maintenance.school.schoolmaintenance');
    }

    public function getcmclist(Request $request)
    {
        $cmcs = CMC::where('district_id', '=', $request->district_id)->get();
        $cmc_list = "<option value=''>Select CMC</option>";
        if (count($cmcs) > 0) {
            foreach ($cmcs as $cmc) {
                $cmc_list .= "<option value='" . $cmc->id . "'>" . ucwords($cmc->cmc_name) . "</option>";
            }
        }
        return $cmc_list;
    }

    public function getcircuitlist(Request $request)
    {
        $circuits = Circuit::where('cmc_id', '=', $request->cmc_id)->get();
        $circuits_list = "<option value=''>Select Circuit</option>";
        if (count($circuits) > 0) {
            foreach ($circuits as $circuit) {
                $circuits_list .= "<option value='" . $circuit->id . "'>" . ucwords($circuit->circuit_name) . "</option>";
            }
        }
        return $circuits_list;
    }

    public function getsubplacelist(Request $request)
    {
        $subplaces = Subplace::where('circuit_id', '=', $request->circuit_id)->get();
        $subplace_list = "<option value=''>Select Sub Place</option>";
        if (count($subplaces) > 0) {
            foreach ($subplaces as $sp) {
                $subplace_list .= "<option value='" . $sp->id . "'>" . ucwords($sp->subplace_name) . "</option>";
            }
        }
        return $subplace_list;
    }
}

<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\StoreDistrictRequest;
use App\Http\Requests\District\UpdateDistrictRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolLocation\DistrictRepositoryInterface;
use App\Models\CMC;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\SchoolDistrict;

class SchoolDistrictController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private DistrictRepositoryInterface $districtRepository;
    function __construct(DistrictRepositoryInterface $districtRepository)
    {
        $this->districtRepository = $districtRepository;

        $this->middleware('permission:district-list|district-create|district-edit|district-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:district-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:district-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:district-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->districtRepository->getAllDistrict();
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.school.district.list', ['data' => $data]);
    }
    //search function
    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->districtRepository->searchDistrict($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.school.district.list', ['data' => $data]);
            }
            return redirect()->route('schooldistricts.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.school.district.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // if ($request->validated()) {
            try {
                $data = $this->districtRepository->addDistrict($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new district failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {  
                return redirect()->route('schooldistricts.index')
                    ->with('success', "New district added successfully!");
            }
            return back()->with('error', 'Adding new district failed.')->withInput();
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
        $district = SchoolDistrict::find($id);
        return view('furniture.maintenance.school.district.edit', compact('district'));
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
                $data = $this->districtRepository->updateDistrict($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating district failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schooldistricts.index')
                    ->with('success', "District updated succe-ssfully!");
            }
            return back()->with('error', 'Updating district failed.')->withInput();
       // }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cmc = CMC::where('district_id', '=', $id)->get();
        try {
            if (count($cmc) > 0) {
                return back()->with('alert', 'School district cannot be deleted as CMCs are added to it.');
            } else {
            }
            $data = $this->districtRepository->deleteDistrict($id);
            return redirect()->route('schooldistricts.index')
                ->with('success', 'School district deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Deleting school district failed. Error - ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Deleting school district failed. Error - ' . $e->getMessage());
        } catch (\Throwable $th) {
            return back()->with('error', 'Deleting school district failed. Error - ' . $th->getMessage());
        }
    }
}

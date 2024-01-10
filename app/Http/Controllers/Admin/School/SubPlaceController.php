<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Subplace\StoreSubplaceRequest;
use App\Http\Requests\Subplace\UpdateSubplaceRequest;
use App\Interfaces\SchoolLocation\SubplaceRepositoryInterface;
use App\Models\School;
use App\Models\Subplace;
use Illuminate\Http\Request;

class SubPlaceController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private SubplaceRepositoryInterface $subplaceRepository;
    function __construct(SubplaceRepositoryInterface $subplaceRepository)
    {
        $this->subplaceRepository = $subplaceRepository;

        $this->middleware('permission:subplace-list|subplace-create|subplace-edit|subplace-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:subplace-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subplace-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subplace-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->subplaceRepository->getAllSubplaces();
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.school.subplaces.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.school.subplaces.add');
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
                $data = $this->subplaceRepository->storeSubplace($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new sub place failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolsubplace.index')
                    ->with('success', "New sub place added successfully!");
            }
            return back()->with('error', 'Adding new sub place failed.')->withInput();
       // }
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
        $subplace = Subplace::find($id);
        return view('furniture.maintenance.school.subplaces.edit', compact('subplace'));
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
      //  if ($request->validated()) {
            try {
                $data = $this->subplaceRepository->updateSubplace($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating sub place failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolsubplace.index')
                    ->with('success', "Sub place updated successfully!");
            }
            return back()->with('error', 'Updating sub place failed.')->withInput();
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schools = School::where('subplace_id', '=', $id)->get();
        try {
            if (count($schools) > 0) {
                return back()->with('alert', 'Sub place cannot be deleted as schools are added to it.');
            } else {
            }
            $data = $this->subplaceRepository->deleteSubplace($id);
            return redirect()->route('schoolsubplace.index')
                ->with('success', 'Sub place deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Deleting sub place failed. Error - ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Deleting sub place failed. Error - ' . $e->getMessage());
        } catch (\Throwable $th) {
            return back()->with('error', 'Deleting sub place failed. Error - ' . $th->getMessage());
        }
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->subplaceRepository->searchSubplace($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.school.subplaces.list', ['data' => $data]);
            }
            return redirect()->route('schoolsubplace.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
}

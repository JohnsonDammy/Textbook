<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMC\StoreCMCRequest;
use App\Http\Requests\CMC\UpdateCMCRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Interfaces\SchoolLocation\CMCRepositoryInterface;
use App\Models\Circuit;
use App\Models\CMC;

class CMCController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private CMCRepositoryInterface $cmcRepository;
    function __construct(CMCRepositoryInterface $cmcRepository)
    {
        $this->cmcRepository = $cmcRepository;

        $this->middleware('permission:cmc-list|cmc-create|cmc-edit|cmc-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:cmc-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cmc-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cmc-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->cmcRepository->getAllCMC();
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.school.cmc.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.school.cmc.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   if ($request->validated()) {
            try {
                $data = $this->cmcRepository->storeCMC($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new CMC failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolcmc.index')
                    ->with('success', "New CMC added successfully!");
            }
            return back()->with('error', 'Adding new CMC failed.')->withInput();
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
        $cmc = CMC::find($id);
        return view('furniture.maintenance.school.cmc.edit', compact('cmc'));
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
        //if ($request->validated()) {
            try {
                $data = $this->cmcRepository->updateCMC($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating CMC failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolcmc.index')
                    ->with('success', "CMC updated successfully!");
            }
            return back()->with('error', 'Updating CMC failed.')->withInput();
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
        $circuits = Circuit::where('cmc_id', '=', $id)->get();
        try {
            if (count($circuits) > 0) {
                return back()->with('alert', 'CMC cannot be deleted as circuits are added to it.');
            } else {
            }
            $data = $this->cmcRepository->deleteCMC($id);
            return redirect()->route('schoolcmc.index')
                ->with('success', 'CMC deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Deleting CMC failed. Error - ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Deleting CMC failed. Error - ' . $e->getMessage());
        } catch (\Throwable $th) {
            return back()->with('error', 'Deleting CMC failed. Error - ' . $th->getMessage());
        }
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->cmcRepository->searchCMC($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.school.cmc.list', ['data' => $data]);
            }
            return redirect()->route('schoolcmc.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
}

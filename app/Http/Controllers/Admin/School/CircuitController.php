<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Circuit\StoreCircuitRequest;
use App\Http\Requests\Circuit\UpdateCircuitRequest;
use App\Http\Requests\SearchRequest;
use App\Interfaces\SchoolLocation\CircuitRepositoryInterface;
use App\Models\Circuit;
use App\Models\Subplace;
use Illuminate\Http\Request;

class CircuitController extends Controller
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private CircuitRepositoryInterface $circuitRepository;
    function __construct(CircuitRepositoryInterface $circuitRepository)
    {
        $this->circuitRepository = $circuitRepository;

        $this->middleware('permission:circuit-list|circuit-create|circuit-edit|circuit-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:circuit-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:circuit-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:circuit-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->circuitRepository->getAllCircuits();
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.school.circuit.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.school.circuit.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCircuitRequest $request)
    {
        if ($request->validated()) {
            try {
                $data = $this->circuitRepository->addCircuit($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new circuit failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolcircuit.index')
                    ->with('success', "New circuit added successfully!");
            }
            return back()->with('error', 'Adding new circuit failed.')->withInput();
        }
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
        $circuit = Circuit::find($id);
        return view('furniture.maintenance.school.circuit.edit', compact('circuit'));
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
        if ($request->validated()) {
            try {
                $data = $this->circuitRepository->updateCircuit($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating circuit failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('schoolcircuit.index')
                    ->with('success', "Circuit updated successfully!");
            }
            return back()->with('error', 'Updating circuit failed.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subplaces = Subplace::where('circuit_id', '=', $id)->get();
        try {
            if (count($subplaces) > 0) {
                return back()->with('alert', 'Circuit cannot be deleted as subplaces are added to it.');
            } else {
            }
            $data = $this->circuitRepository->deleteCircuit($id);
            return redirect()->route('schoolcircuit.index')
                ->with('success', 'Circuit deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Deleting circuit failed. Error - ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Deleting circuit failed. Error - ' . $e->getMessage());
        } catch (\Throwable $th) {
            return back()->with('error', 'Deleting circuit failed. Error - ' . $th->getMessage());
        }
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->circuitRepository->searchCircuit($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.school.circuit.list', ['data' => $data]);
            }
            return redirect()->route('schoolcircuit.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
}

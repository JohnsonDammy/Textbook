<?php

namespace App\Repositories\SchoolLocation;

use App\Interfaces\SchoolLocation\CircuitRepositoryInterface;
use App\Models\Circuit;
use App\Models\Subplace;
use Illuminate\Support\Facades\Request;

class CircuitRepository implements CircuitRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    public function getAllCircuits()
    {
        try {
            $circuit = Circuit::orderBy('circuit_name')->paginate(10);
            if (Request::input("all")) {
                $circuit = Circuit::orderBy('circuit_name')->get();
            }
        } catch (\Throwable $th) {
            $circuit = null;
            throw $th;
        }
        return $circuit;
    }

    public function getSingleCircuit($id)
    {
        try {
            //accessing record for circuit
            $circuit = Circuit::find($id);
        } catch (\Throwable $th) {
            $circuit = null;
            throw $th;
        }
        return $circuit;
    }

    public function addCircuit($request)
    {
        try {
            //creating record for circuit 
            $circuit = Circuit::create([
                'circuit_name' => $request->circuit_name,
                'cmc_id' => $request->cmc_id,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $circuit;
    }

    public function updateCircuit($request, $id)
    {

        try {
            //accessing record for circuit
            $circuit = Circuit::find($id);
            //checking circuit whether present in database or not
            if (!$circuit) {
                return null;
            }
            $circuit->circuit_name = $request->circuit_name;
            $circuit->cmc_id = $request->cmc_id;
            $circuit->update();
        } catch (\Throwable $th) {
            $circuit = null;
            throw $th;
        }
        return $circuit;
    }

    public function deleteCircuit($id)
    {

        try {
            //accessing record for circuit
            $circuit = Circuit::find($id);
            //checking whether any subplace has assigned to this circuit
            $subplace = Subplace::where('circuit_id', $id)->first();
            if (!$circuit || $subplace) {
                return null;
            }
            $circuit->delete();
        } catch (\Throwable $th) {
            $circuit = null;
            throw $th;
        }
        return $circuit;
    }

    public function searchCircuit($circuit_name)
    {
        $data = Circuit::where('circuit_name', 'like', '%' . $circuit_name . '%')
            ->orderBy('circuit_name')->paginate(10)->withQueryString();

        //for api
        if (Request::capture()->is('api/*')) {
            $data = Circuit::where('circuit_name', 'like', '%' . $circuit_name . '%')
                ->orderBy('circuit_name')->get();
        }
        return $data;
    }
}

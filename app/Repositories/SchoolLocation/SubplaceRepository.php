<?php

namespace App\Repositories\SchoolLocation;

use App\Interfaces\SchoolLocation\SubplaceRepositoryInterface;
use App\Models\Subplace;
use Illuminate\Support\Facades\Request;

class SubplaceRepository implements SubplaceRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    public function getAllSubplaces()
    {
        try {
            $subplace = Subplace::orderBy('subplace_name')->paginate(10);
            if (Request::input("all")) {
                $subplace = Subplace::orderBy('subplace_name')->get();
            }
        } catch (\Throwable $th) {
            $subplace = null;
            throw $th;
        }
        return $subplace;
    }

    public function getSingleSubplace($id)
    {
        try {
            //accessing record for circuit
            $subplace = Subplace::find($id);
        } catch (\Throwable $th) {
            $subplace = null;
            throw $th;
        }
        return $subplace;
    }

    public function storeSubplace($request)
    {
        try {
            //creating record for subplace 
            $subplace = Subplace::create([
                'subplace_name' => $request->subplace_name,
                'circuit_id' => $request->circuit_id,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $subplace;
    }

    public function updateSubplace($request, $id)
    {

        try {
            //accessing record for subplace
            $subplace = Subplace::find($id);
            //checking subplace whether present in database or not
            if (!$subplace) {
                return null;
            }
            $subplace->subplace_name = $request->subplace_name;
            $subplace->circuit_id = $request->circuit_id;
            $subplace->update();
        } catch (\Throwable $th) {
            $subplace = null;
            throw $th;
        }
        return $subplace;
    }

    public function deleteSubplace($id)
    {

        try {
            //accessing record for circuit
            $subplace = Subplace::find($id);
            // //checking whether any subplace has assigned to this subplace
            // $subplace = Subplace::where('subplace_id', $id)->first();
            if (!$subplace) {
                return null;
            }
            $subplace->delete();
        } catch (\Throwable $th) {
            $subplace = null;
            throw $th;
        }
        return $subplace;
    }

    public function searchSubplace($subplace_name)
    {
        $data = Subplace::where('subplace_name', 'like', '%' . $subplace_name . '%')
            ->orderBy('subplace_name')->paginate(10)->withQueryString();

        //for api
        if (Request::capture()->is('api/*')) {
            $data = Subplace::where('subplace_name', 'like', '%' . $subplace_name . '%')
                ->orderBy('subplace_name')->get();
        }
        return $data;
    }
}

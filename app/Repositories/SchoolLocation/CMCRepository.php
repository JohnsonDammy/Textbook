<?php

namespace App\Repositories\SchoolLocation;

use App\Interfaces\SchoolLocation\CMCRepositoryInterface;
use App\Models\Circuit;
use App\Models\CMC;
use Illuminate\Support\Facades\Request;

class CMCRepository implements CMCRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    public function getAllCMC()
    {
        try {
            $cmc = CMC::orderby('cmc_name')->paginate(10);
            if (Request::input("all")) {
                $cmc = CMC::orderby('cmc_name')->get();
            }
        } catch (\Throwable $th) {
            $cmc = null;
            throw $th;
        }
        return $cmc;
    }

    public function storeCMC($request)
    {
        try {
            //creating record for cmc 
            $cmc = CMC::create([
                'cmc_name' => $request->cmc_name,
                'district_id' => $request->district_id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $cmc;
    }
    public function updateCMC($request, $id)
    {

        try {
            //accessing record for cmc
            $cmc = CMC::find($id);
            //checking cmc whether present in database or not
            if (!$cmc) {
                return null;
            }
            $cmc->cmc_name = $request->cmc_name;
            $cmc->district_id = $request->district_id;
            $cmc->update();
        } catch (\Throwable $th) {
            $cmc = null;
            throw $th;
        }
        return $cmc;
    }
    public function getSingleCMC($id)
    {

        try {
            //accessing record for cmc
            $cmc = CMC::find($id);
        } catch (\Throwable $th) {
            $cmc = null;
            throw $th;
        }
        return $cmc;
    }
    public function deleteCMC($id)
    {

        try {
            //accessing record for cmc
            $cmc = CMC::find($id);
            //checking whether any circuit has assigned to this cmc
            $circut = Circuit::where('cmc_id', $id)->first();
            if (!$cmc || $circut) {
                return null;
            }
            $cmc->delete();
        } catch (\Throwable $th) {
            $cmc = null;
            throw $th;
        }
        return $cmc;
    }

    public function searchCMC($cmc_name)
    {
        $data = CMC::where('cmc_name', 'like', '%' . $cmc_name . '%')
            ->orderBy('cmc_name')->paginate(10)->withQueryString();

        //for api
        if (Request::capture()->is('api/*')) {
            $data = CMC::where('cmc_name', 'like', '%' . $cmc_name . '%')
                ->orderBy('cmc_name')->get();
        }
        return $data;
    }
}

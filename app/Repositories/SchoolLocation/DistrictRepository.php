<?php

namespace App\Repositories\SchoolLocation;

use App\Interfaces\SchoolLocation\DistrictRepositoryInterface;
use App\Models\CMC;
use App\Models\SchoolDistrict;
use Illuminate\Support\Facades\Request;

class DistrictRepository implements DistrictRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    public function getAllDistrict()
    {
        $data = SchoolDistrict::orderBy('district_office')->paginate(10);
        if (Request::input("all")) {
            $data = SchoolDistrict::orderBy('district_office')->get();
        }
        return $data;
    }



    public function getSingleDistrict($id)
    {
        return SchoolDistrict::find($id);
    }
    public function deleteDistrict($id)
    {
        try {
            $cmc = CMC::where('district_id', $id)->first();
            if ($cmc) {
                return null;
            }
            $district = SchoolDistrict::find($id);
            $district->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return $district;
    }
    // public function addDistrict($request)
    // {
    //     $district = SchoolDistrict::create([
    //         'district_office' => $request->district_office
    //         // 'director' => $request->director,
    //         // 'tel' => $request->tel,
    //         // 'address1' => $request->address1,
    //         // 'address2' => $request->address2,
    //         // 'address3' => $request->address3,
    //         // 'address4' => $request->address4,
    //         // 'street_code' => $request->street_code
    //     ]);

    //     return $district;
    // }


    public function addDistrict($request)
    {
        $district = new SchoolDistrict();
        $district->setConnection('itrfurns');
    
        $district->district_office = $request->district_office;
    
        $district->save();
    
        return $district;
    }
    

    public function updateDistrict($request, $id)
    {
        $district = SchoolDistrict::find($id);
        $district->district_office = $request->district_office;
        // $district->director = $request->director;
        // $district->tel = $request->tel;
        // $district->address1 = $request->address1;
        // $district->address2 = $request->address2;
        // $district->address3 = $request->address3;
        // $district->address4 = $request->address4;
        // $district->street_code = $request->street_code;
        $district->update();
        return $district;
    }

    public function searchDistrict($query)
    {
        $data = SchoolDistrict::where('district_office', 'like', '%' . $query . '%')
            ->orderBy('district_office')->paginate(10)->withQueryString();

        //for api
        if (Request::capture()->is('api/*')) {
            $data = SchoolDistrict::where('district_office', 'like', '%' . $query . '%')
                ->orderBy('district_office')->get();
        }
        return $data;
    }
}

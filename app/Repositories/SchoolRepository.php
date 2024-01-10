<?php

namespace App\Repositories;

use App\Interfaces\SchoolRepositoryInterface;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class SchoolRepository implements SchoolRepositoryInterface
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    public function getAllSchool()
    {
        $school = School::orderBy('name')->paginate(10);
        if (Request::input("all")) {
            $school = School::orderBy('name')->get();
        }
        return $school;
    }

    public function getSingleSchool($id)
    {
        return School::find($id);
    }

    public function addSchool($request)
    {
        $school = School::create([
            'name' => $request->name,
            'emis' => $request->emis,
            'district_id' => $request->district_id,
            'cmc_id' => $request->cmc_id,
            'circuit_id' => $request->circuit_id,
            'subplace_id' => $request->subplace_id,
            'snq_id' => $request->snq_id,
            'level_id' => $request->level_id,
            'school_principal' => $request->school_principal,
            'tel' => $request->tel,
            'street_code' => $request->street_code
        ]);

        return $school;
    }

    public function updateSchool($request, $id)
    {
        $school = School::find($id);
        $school->name = $request->name;
        $school->emis = $request->emis;
        $school->district_id = $request->district_id;
        $school->cmc_id = $request->cmc_id;
        $school->circuit_id = $request->circuit_id;
        $school->subplace_id = $request->subplace_id;
        $school->snq_id = $request->snq_id;
        $school->level_id = $request->level_id;
        $school->school_principal = $request->school_principal;
        $school->tel = $request->tel;
        $school->street_code = $request->street_code;
        $school->update();

        return $school;
    }

    public function deleteSchool($id)
    {
        $school = School::find($id);
        $user = User::where('username', $school->emis)->first();
        if (!$user) {
            $school->delete();
            return $school;
        }
        return null;
    }

    public function searchSchool($query)
    {
        $school = School::where('name', 'like', '%' . $query . '%')
            ->orWhere('emis', 'like', '%' . $query . '%')
            ->orWhere('school_principal', 'like', '%' . $query . '%')
            ->orderBy('name')->paginate(10)->withQueryString();
        if (Request::capture()->is('api/*')) {
            $school = School::where('name', 'like', '%' . $query . '%')
                ->orWhere('emis', 'like', '%' . $query . '%')
                ->orWhere('school_principal', 'like', '%' . $query . '%')
                ->orderBy('name')->get();
        }
        return $school;
    }
}

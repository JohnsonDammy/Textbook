<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\CMC;
use App\Models\School;
use App\Models\SchoolDistrict;
use App\Models\SchoolLevel;
use App\Models\SchoolSnq;
use App\Models\Subplace;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelSchoolController extends Controller
{
    public function AddressDetailsImport()
    {
        echo '<h1>Importing Address data...</h1>';
        DB::beginTransaction();
        try {

            //generarating path
            $inptFilePath = public_path('/') . "school_details.xlsx";
            //accessing data from sheet
            $spreadSheet = IOFactory::load($inptFilePath);

            //all data extracting inavaribale
            // $sheetData = $spreadSheet->getActiveSheet()->toArray(null, true, true, true);
            $sheetData = $spreadSheet->getSheetByName("Summary")->toArray(null, true, true, true);


            //getting unique districts for column B
            $districtData = array_unique(array_column($sheetData, "A"));

            // dd($districtData);
            foreach ($districtData as $key => $value) {
                if ($value != "DISTRICT" && $value != "TOTAL" && !empty($value) && !SchoolDistrict::where("district_office", $value)->first()) {
                    SchoolDistrict::create([
                        "district_office" => strtolower($value)
                    ]);
                }
            }

            //getting unique cmc for column C
            $cmcData = array_unique(array_column($sheetData, "B"));

            $currentDistrict = '';
            foreach ($sheetData as $key => $value) {
                // $currentDistrict = isset($value['A']) ? $value['A'] : $currentDistrict;
                if (isset($value['A']) && $value['A'] != "TOTAL" && $value['A'] != "DISTRICT") {
                    $currentDistrict = $value['A'];
                } else {
                    $currentDistrict = $currentDistrict;
                }
                // echo "$currentDistrict <br>";

                if ($value['B'] != "CMC" && $value['B'] != "TOTAL" && !empty($value['B']) && $value['B'] != '(blank)' && $currentDistrict != '' && !CMC::where("cmc_name", strtolower($value['B']))->first()) {
                    $district = SchoolDistrict::where("district_office", strtolower($currentDistrict))->first();
                    CMC::create([
                        "cmc_name" => strtolower($value['B']),
                        "district_id" => $district->id,
                    ]);
                }
            }
            // dd($currentDistrict);

            $currentCmc = '';
            foreach ($sheetData as $key => $value) {
                if (isset($value['B']) && $value['B'] != '(blank)' && $value['B'] != "TOTAL" && $value['B'] != "CMC") {
                    $currentCmc = $value['B'];
                } else {
                    $currentCmc = $currentCmc;
                }
                if (isset($value['C']) && $value['C'] != '(blank)' && $value['C'] != "CIRCUIT" && $value['C'] != "Total" && $currentCmc != '' && !Circuit::where("circuit_name", strtolower($value['C']))->first()) {
                    $cmc = CMC::where("cmc_name", $currentCmc)->first();
                    // echo  "cmc :" . $currentCmc . " and " . $cmc->cmc_name . " &nbsp;&nbsp;&nbsp;" . $value['C'] . "<br>";
                    $circuit = Circuit::where('circuit_name', $value['C'])->first();
                    if ($cmc && !$circuit) {
                        Circuit::Create([
                            "circuit_name" => strtolower($value['C']),
                            "cmc_id" => $cmc->id
                        ]);
                    }
                }
            }
            $currentCircuit = '';
            foreach ($sheetData as $key => $value) {
                if (isset($value['C']) && $value['C'] != '(blank)' && $value['C'] != "TOTAL" && $value['C'] != "CIRCUIT") {
                    $currentCircuit = $value['C'];
                } else {
                    $currentCircuit = $currentCircuit;
                }
                if (isset($value['D']) && $value['D'] != '(blank)' && $value['D'] != "SUBPLACENAME" && $value['D'] != "Total" && $value['D'] != "NONE" && $currentCircuit != '' && !Subplace::where("subplace_name", strtolower($value["D"]))->first()) {
                    $cmc = Circuit::where("circuit_name", $currentCircuit)->first();
                    // echo  "cmc :" . $currentCmc . " and " . $cmc->cmc_name . " &nbsp;&nbsp;&nbsp;" . $value['C'] . "<br>";
                    Subplace::Create([
                        "subplace_name" => strtolower($value['D']),
                        "circuit_id" => $cmc->id
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return redirect()->route("school-details-import");
    }

    public function SchoolDEtailsImport()
    {
        echo '<h1>Importing School data...</h1>';
        ini_set('max_execution_time', 300);
        //generating excel file path
        $inptFilePath = public_path('/') . "school_details.xlsx";
        //accessing data from sheet
        $spreadSheet = IOFactory::load($inptFilePath);

        //accesing sheet data from School sheet 
        $sheetData = $spreadSheet->getSheetByName("School Detail")->toArray(null, true, true, true);

        DB::beginTransaction();
        try {
            foreach ($sheetData as $key => $value) {
                if ($value['A'] != "EMIS" && $value['B'] != "DISTRICT " && $value['C'] != "CMC" && $value['D'] != "CIRCUIT" && $value['E'] != "SUBPLACENAME" && $value['F'] != "SCHOOL" && $value['G'] != "LEVEL" && $value['H'] != "SNQ") {
                    $emis = $value['A'];
                    $district = $value['B'];
                    $cmc = $value['C'];
                    $circuit = $value['D'];
                    $subplace = $value['E'];
                    $school = $value['F'];
                    $level = $value['G'];
                    $snq = $value['H'];

                    $district = SchoolDistrict::where("district_office", strtolower($district))->first();
                    $cmc = CMC::where("cmc_name", strtolower($cmc))->first();
                    $snq = SchoolSnq::where("name", $snq)->first();
                    $level = SchoolLevel::where("name", strtoupper($level))->first();
                    $circuit = Circuit::where("circuit_name", strtolower($circuit))->first();
                    $subplace = Subplace::where("subplace_name", strtolower($subplace))->first();
                    $emisExist = School::where('emis', $emis)->first();
                    if ($district && $cmc && $circuit && !$emisExist) {
                        $school =  School::create([
                            "name" => $school,
                            "emis" => $emis,
                            "district_id" => $district->id,
                            "cmc_id" => $cmc->id,
                            "circuit_id" => $circuit->id,
                            "subplace_id" => $subplace ? $subplace->id : null,
                            "snq_id" => $snq->id,
                            "level_id" => $level->id
                        ]);
                    }
                }
            }
            DB::commit();
           
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return redirect("/");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\savedSuppliers;
use App\Models\SuppliyerModel;
use App\Models\capturedsuppliers;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolSuppliyerModel;

use App\Models\School;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SuppliyerController extends Controller
{
    //
    public function index()
    {

        // //INSERT INTO school_suppliyer(Id, Suppliyer_id, Emis, IsActive, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
        // $emis = Auth::user()->username;

        // //$Sup  = SchoolSuppliyerModel::where('', $district_id)->get();

        // //$SuppliyerID = SchoolSuppliyerModel::where('Emis', $emis)->value('Suppliyer_id');

        // $isActive = "1";
        // $data = SchoolSuppliyerModel::where('Emis', $emis)
        //     ->where('IsActive', $isActive)
        //     ->paginate(10);



        // return view('furniture.Suppliyer.list', compact('data'));



        $emis = Auth::user()->username;
        if ($emis === "Admin") {
            $data = DB::table('suppliyer')->paginate(10);

            return view('furniture.Suppliyer.list', compact('data'));
        } else {

            $isActive = "1";

            $suppliersData = savedSuppliers::all();
          $capturedSuppliers= capturedsuppliers::all();

            $data = DB::table('school_suppliyer')
                ->join('suppliyer', 'school_suppliyer.Suppliyer_id', '=', 'suppliyer.Id')
                ->select('school_suppliyer.*', 'school_suppliyer.Suppliyer_id','suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact', 'suppliyer.ISActive', 'suppliyer.Date')
                ->where('school_suppliyer.Emis', $emis)
                ->where('school_suppliyer.IsActive', $isActive)
                ->paginate(10);


                

            return view('furniture.Suppliyer.list', compact('data','suppliersData', 'capturedSuppliers'));
        }
    }


    public function add()
    {
        return view('furniture.Suppliyer.add');
    }

    public function downloadQuoteSupplier($supplierID)
    {
 
        $emis = Auth::user()->username;
        $savedSupplierID = savedSuppliers::where('supplierID', $supplierID)->where('emis', $emis)->value('id');
 
        $filename = capturedsuppliers::where('savedSupplierID',  $savedSupplierID )->value('quoteForm');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/quotes/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadSBD4Supplier($supplierID)
    {
 
        $emis = Auth::user()->username;
        $savedSupplierID = savedSuppliers::where('supplierID', $supplierID)->where('emis', $emis)->value('id');
        $filename = capturedsuppliers::where('savedSupplierID',  $savedSupplierID)->value('sbd4Form');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/sbd4/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }

    public function AddSuppliyer(Request $request)
    {
        $emis = Auth::user()->username;

        if ($emis === "Admin") {

            $isActive = "1";

            //    //INSERT INTO suppliyer(Id, email, CompanyName, CompanyAddress, CompanyContact, ISActive) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
            $SuppliyerData =  [
                'email' => $request->input('Email'),
                'CompanyName' => $request->input('CompanyName'),
                'CompanyAddress' => $request->input('CompanyAddress'),
                'CompanyContact' => $request->input('CompanyContact'),
                'ISActive' => $isActive
            ];

            DB::table('suppliyer')->insert($SuppliyerData);

            $Activity_ID = "3";

            $message = "Admin Add New Supplier";

            $logsactivity = [
                'DescriptionActivities' => $message,
                'Who' => $emis,
                'Activity_ID' => $Activity_ID,

            ];
            DB::table('logsactivity')->insert($logsactivity);

            return redirect()->route('Suppliyer.list')->with('success', 'Supplier Added Successfully');
        } else {
            $Email = $request->input('Email'); // Get the selected option

            $existemail = SuppliyerModel::where('email', $Email)->first(); // From Suppliyer
            if ($existemail !== null) {

                // $existemail2 = SchoolSuppliyerModel::where('Suppliyer_id', $existemail->Id)->first(); // From School Supplier

                $existemail2 = SchoolSuppliyerModel::where('Suppliyer_id', $existemail->Id)
                    ->where('Emis', $emis)
                    ->where('IsActive', "1")
                    ->first();

                $isActive = "1";


                if ($existemail == true && $existemail2 == true) {


                    return redirect()->route('Suppliyer.list')->with('errorMessage', 'Cannot Add Supplier Already Exits');
                } elseif ($existemail == true && $existemail2 == false) {

                    SchoolSuppliyerModel::create([
                        'Suppliyer_id' => $existemail->Id,
                        'Emis' => $emis,
                        'IsActive' => 1,
                        'Date' => now(), // Use the current date
                    ]);



                    //INSERT INTO logsactivity(Id, DescriptionActivities, Who, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
                    $SchoolName = DB::connection('itrfurns')->table('schools')
                        ->where('emis', $emis)
                        ->value('name');

                    $message = "From  :" . $emis . " , " . $SchoolName . "has Added New supplier";
                    $Activity_ID = "1";

                    $logsactivity = [
                        'DescriptionActivities' => $message,
                        'Who' => $emis,
                        'Activity_ID' => $Activity_ID,

                    ];
                    DB::table('logsactivity')->insert($logsactivity);

                    return redirect()->route('Suppliyer.list')->with('success', 'Supplier Added Successfully');
                }
            } else {
                $isActive = "1";


                //    //INSERT INTO suppliyer(Id, email, CompanyName, CompanyAddress, CompanyContact, ISActive) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
                $SuppliyerData =  [
                    'email' => $request->input('Email'),
                    'CompanyName' => $request->input('CompanyName'),
                    'CompanyAddress' => $request->input('CompanyAddress'),
                    'CompanyContact' => $request->input('CompanyContact'),
                    'ISActive' => $isActive
                ];

                //INSERT INTO logsactivity(Id, DescriptionActivities, Who, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
                $SchoolName = DB::connection('itrfurns')->table('schools')
                    ->where('emis', $emis)
                    ->value('name');
                    $Activity_ID = "1";


                $message = "From  :" . $emis . " , " . $SchoolName . "has Added New supplier";

                $logsactivity = [
                    'DescriptionActivities' => $message,
                    'Who' => $emis,
                    'Activity_ID' => $Activity_ID,

                ];
                DB::table('logsactivity')->insert($logsactivity);


                $SchoolEmis = $request->input('Emis'); // Get the selected option

                $NewIsActive = "1";
                $SuppliyerId = DB::table('suppliyer')->insertGetId($SuppliyerData);
                //INSERT INTO school_suppliyer(Id, Suppliyer_id, Emis, email, CompanyName, CompanyAddress, CompanyContact, IsActive, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
                //INSERT INTO school_suppliyer(Id, Suppliyer_id, Emis, IsActive, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
                $SchoolSuppliyer = [
                    'Suppliyer_id' => $SuppliyerId,
                    'Emis' => $SchoolEmis,

                    'IsActive' => $NewIsActive


                ];

                DB::table('school_suppliyer')->insert($SchoolSuppliyer);
                // return redirect()->route('Suppliyer.Add')->with('success', 'Suppliyer Added Successfully');

                //return view('furniture.Suppliyer.list')->with('success', 'Supplier Added Successfully');
                return redirect()->route('Suppliyer.list')->with('success', 'Supplier Added Successfully');
            }
        }
    }


    public function edit($id)
    {
        // protected $fillable = ['Id', 'Suppliyer_id', 'Emis', 'email', 'CompanyName', 'CompanyAddress',  'CompanyContact', 'IsActive'];
        // Retrieve a single record by its ID
        $data  = SuppliyerModel::where('Id', $id)->first();

        return view('furniture.Suppliyer.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $emis = Auth::user()->username;

        if ($emis === "Admin") {
            //INSERT INTO school_suppliyer(Id, Suppliyer_id, Emis, email, CompanyName, CompanyAddress, CompanyContact, IsActive, Date, updated_at, created_at) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
            $ID = $request->input('IDVAl');
            $CompanyName = $request->input('CompanyName');
            $Email = $request->input('Email');
            $CompanyAddress = $request->input('CompanyAddress');
            $CompanyContact = $request->input('CompanyContact');


            DB::table('suppliyer')
                ->where('Id', $ID)

                ->update([
                    'CompanyName' => $CompanyName,
                    'email' => $Email,
                    'CompanyAddress' => $CompanyAddress,
                    'CompanyContact' => $CompanyContact,
                ]);


            $message = "Admin Has Update The Supplier List";
            $Activity_ID = "3";

            $logsactivity = [
                'DescriptionActivities' => $message,
                'Who' => $emis,
                'Activity_ID' => $Activity_ID,

            ];
            DB::table('logsactivity')->insert($logsactivity);

            return redirect()->route('Suppliyer.list')->with('successD', 'Supplier updated successfully');
        } else {
            //INSERT INTO school_suppliyer(Id, Suppliyer_id, Emis, email, CompanyName, CompanyAddress, CompanyContact, IsActive, Date, updated_at, created_at) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
            $ID = $request->input('IDVAl');
            $CompanyName = $request->input('CompanyName');
            $Email = $request->input('Email');
            $CompanyAddress = $request->input('CompanyAddress');
            $CompanyContact = $request->input('CompanyContact');


            DB::table('suppliyer')
                ->where('Id', $ID)

                ->update([
                    'CompanyName' => $CompanyName,
                    'email' => $Email,
                    'CompanyAddress' => $CompanyAddress,
                    'CompanyContact' => $CompanyContact,
                ]);

            //INSERT INTO logsactivity(Id, DescriptionActivities, Who, Date) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
            $SchoolName = DB::connection('itrfurns')->table('schools')
                ->where('emis', $emis)
                ->value('name');

            $message = "From  :" . $emis . " , " . $SchoolName . " has Update supplier details";
                    $Activity_ID = "1";

                        $logsactivity = [
                'Activity_ID' => $Activity_ID,

                'DescriptionActivities' => $message,
                'Who' => $emis,

            ];
            DB::table('logsactivity')->insert($logsactivity);

            return redirect()->route('Suppliyer.list')->with('successD', 'Supplier updated successfully');
        }
    }


    public function DeleteSuppliar(Request $request)
    {

        $emis = Auth::user()->username;

        if($emis === "Admin"){
            $ID = $request->input('DelVal');


            DB::table('suppliyer')
                ->where('Id', $ID)->delete();

                
        DB::table('school_suppliyer')
        ->where('Suppliyer_id', $ID)->delete();

        return redirect()->route('Suppliyer.list')->with('errorMessage', 'Supplier delete successfully');


                
        }else{
            $ID = $request->input('DelVal');

            DB::table('school_suppliyer')
                ->where('Id', $ID)
    
                ->update([
                    'IsActive' => "0",
                ]);
    
            // DB::table('school_suppliyer')->where('Id', $ID)->delete();
    
            return redirect()->route('Suppliyer.list')->with('errorMessage', 'Supplier delete successfully');
    
            //DB::table($tables)->delete();
        }

 
    }

    public function search(Request $request)
    {
        $emis = Auth::user()->username;
        $query = $request->input('query');

        $data = DB::table('school_suppliyer')
            ->join('suppliyer', 'school_suppliyer.Suppliyer_id', '=', 'suppliyer.Id')
            ->select('school_suppliyer.*', 'suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact', 'suppliyer.ISActive', 'suppliyer.Date')
            ->where('school_suppliyer.Emis', $emis)
            ->where('school_suppliyer.IsActive', 1)
            ->where(function ($subQuery) use ($query) {
                $subQuery->where('suppliyer.CompanyName', 'like', '%' . $query . '%')
                    ->orWhere('suppliyer.email', 'like', '%' . $query . '%')
                    ->orWhere('suppliyer.CompanyAddress', 'like', '%' . $query . '%')
                    ->orWhere('suppliyer.CompanyContact', 'like', '%' . $query . '%');
            })
            ->paginate(10);

        return view('furniture.Suppliyer.list', compact('data'));
    }

}

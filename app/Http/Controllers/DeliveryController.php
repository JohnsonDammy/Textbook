<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommitteeModel;
use App\Models\School;
use App\Models\RequestFundsModel;
use App\Models\RequestPrecurementModel;

use App\Models\DeliveryModel;
use App\Models\SuppliyerModel;

use App\Models\SchoolSuppliyerModel;
use App\Models\User;

class DeliveryController extends Controller
{
    //
    Public function index(Request $request){

       $org = Auth::user()->organization;
       $user = Auth::user()->username;

       $district_id = User::where('username', $user)->value('District_id');

       if($org === 3){

       // return redirect()->route('Delivery.list')->with('success', 'Delivery Uploaded successfully');

   $isActive = "1";

     $data = DB::table('deliveryselection')
      ->join('suppliyer', 'deliveryselection.SupplierID', '=', 'suppliyer.Id')
     ->select('deliveryselection.*', 'suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact', 'suppliyer.ISActive', 'suppliyer.Date')
      ->where('deliveryselection.District_Id', $district_id)
 ->paginate(10);

return view('furniture.Delivery.list', compact('data'));

       }else{
     $emis = Auth::user()->username;
       $isActive = "1";

       $data = DB::table('deliveryselection')
            ->join('suppliyer', 'deliveryselection.SupplierID', '=', 'suppliyer.Id')
           ->select('deliveryselection.*', 'suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact', 'suppliyer.ISActive', 'suppliyer.Date', 'deliveryselection.RequestType')
           ->where('deliveryselection.Emis', $emis)
           ->paginate(10);

 return view('furniture.Delivery.list', compact('data'));



       }


    }

    public function add()
    {

        //INSERT INTO `procurementselection`(`id`, `Textbook`, `Stationary`, `NoDeclaration`, `School_Emis`, `SchoolName`, `Date`, `year`, `ActionBy`, `circular_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
        $emis = Auth::user()->username;


        $allDataText = DB::table('suppliyer')
        ->select(
            'suppliyer.Id',
            'suppliyer.email',
            'suppliyer.CompanyName',
            'suppliyer.CompanyContact',
            'suppliyer.CompanyAddress',
            'suppliyer.ISActive',
            'suppliyer.CompanyName',
            'capturedsuppliers.amount',
            'savedsuppliers.emis',
            'savedsuppliers.requestType',
            'capturedsuppliers.Recommended'
        )
        ->join('savedsuppliers', 'suppliyer.Id', '=', 'savedsuppliers.supplierID')
        ->join('capturedsuppliers', 'savedsuppliers.id', '=', 'capturedsuppliers.savedSupplierID')
        ->where('savedsuppliers.emis', '=', $emis)
        ->where('savedsuppliers.requestType', '=', 'Textbook')
        ->where('capturedsuppliers.Recommended', '=', 'yes')
        ->get();
    


    
    $allDataStationary = DB::table('suppliyer')
    ->select('suppliyer.Id','suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyContact', 'suppliyer.CompanyAddress', 'suppliyer.ISActive', 'suppliyer.CompanyName', 'capturedsuppliers.amount', 'savedsuppliers.emis', 'savedsuppliers.requestType', 'capturedsuppliers.Recommended')
    ->join('savedsuppliers', 'suppliyer.Id', '=', 'savedsuppliers.supplierID')
    ->join('capturedsuppliers', 'savedsuppliers.id', '=', 'capturedsuppliers.savedSupplierID')
    ->where('savedsuppliers.emis', '=', $emis)
    ->where('savedsuppliers.requestType', '=', 'Stationery')
    ->where('capturedsuppliers.Recommended', '=', 'yes')
    ->get();

        // Use get() to execute the query and retrieve the results
        //$allData = School::where('emis', $emis)->get();

        $CheckValueTextbook = RequestPrecurementModel::where('School_Emis' , $emis)->value('Textbook');
        $CheckValueStationary = RequestPrecurementModel::where('School_Emis' , $emis)->value('Stationary');


    
        // Pass the data to the view
        return view('furniture.Delivery.add', compact('allDataText', 'allDataStationary', 'CheckValueTextbook' , 'CheckValueStationary'));

    }

    public function AddDelivery(Request $request){

     $emis = Auth::user()->username;
       $file = $request->file('filename');
     $district_id = School::where('emis', $emis)->value('district_id');

     $ReferencesNo = RequestFundsModel::where('School_Emis', $emis)->value('References_Number');

     $fileName = "DeliveryNote_".uniqid() . '_' . $file->getClientOriginalName();

    $destinationPath='public/Delivery';   
          $file->move( $destinationPath, $fileName);


$RequestType = $request->input('requestType');
 $SupplierID = $request->input('SupplierID');

 $Datees = $request->input('DeliveryDate');


// //INSERT INTO `deliveryselection`(`Id`, `Emis`, `District_Id`, `SupplierID`, `FilePath`, `RecievedQuantity`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
  DB::table('deliveryselection')->insert([
'Emis' => $emis,
'District_Id' => $district_id,
'SupplierID' => $SupplierID,
 'FilePath' => $fileName,
 'RequestType' => $RequestType,
 'References_Number' => $ReferencesNo,
 'date' => $Datees,
 'IsActive' => '1'
 ]);
   
       // return redirect()->back()->with('success', 'Delivery Uploaded successfully.');
        return redirect()->route('Delivery.list')->with('success', 'Delivery Uploaded successfully');
    }


    public function edit($id)
    {
  
        $data  = DeliveryModel::where('Id', $id)->first();

        return view('furniture.Delivery.edit', compact('data'));
    }


    public function update(Request $request){

        $ID = $request->input('IDVAl');

        $emis = Auth::user()->username;

        $file = $request->file('filename');
    //    $district_id = School::where('emis', $emis)->value('district_id');
   
        $fileName = "DeliveryNote_".uniqid() . '_' . $file->getClientOriginalName();
   
       $destinationPath='public/Delivery';   
             $file->move( $destinationPath, $fileName);
   
        DB::table('deliveryselection')
            ->where('Id', $ID)

            ->update([
                'FilePath' => $fileName,
            ]);

            return redirect()->route('Delivery.list')->with('successD', 'Delivery Note updated successfully');

    }

    public function DeleteDeliveryNote(Request $request){
        $ID = $request->input('DelVal');


        DB::table('deliveryselection')
            ->where('Id', $ID)

            ->delete();

        return redirect()->route('Delivery.list')->with('errorMessage', 'Delivery Note delete successfully');
    }
}

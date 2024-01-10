<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UploadModel;
use App\Imports\ImportUser;
use App\Imports\ImportTextbookCat;
use App\Imports\ImportStationary;




use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UploadController extends Controller
{
public function index(){
    $connection = 'itrfurns';
    $table = 'alloctionfunddata';
    $data = DB::connection($connection)->table($table)->get();

    return view('furniture.Upload.upload', compact('data'));
}


public function uploadData(Request $request)
{

  ini_set('memory_limit', '1024M'); // Set memory limit to 1GB

    $request->validate([
        'file' => 'required|mimes:csv,xlsx,xls',
    ]);

    $file = $request->file('file');
    
   // $TextbookFile = $request->file('Textbookfile');

    Excel::import(new  ImportUser,  //Allocation funds
     $request->file('file')->store('files')); // Use the appropriate import class


    $fileName = "Section 21 C Funds Allocation_".uniqid() . '_' . $file->getClientOriginalName();

    $destinationPath='public/ApprovePdf';   
   $file->move( $destinationPath, $fileName);

    $Descript = "SECTION 21C FUNDS ALLOCATION FOR THE YEAR ".date('Y');
    DB::connection('itrfurns')->table('alloctionfunddata')->insert([
        'Description' => $Descript,
        'file' => $fileName,
     ]);

     return redirect()->back()->with('success', 'Data imported successfully.');
    // return response()->json(['message' => 'Data imported successfully']);

}




public function uploadcat(Request $request){

  ini_set('memory_limit', '1024M'); // Set memory limit to 1GB


  $request->validate([
        'Textbookfile' => 'required|mimes:csv,xlsx,xls',
]);

   $TextbookFile = $request->file('Textbookfile');

    Excel::import(new ImportTextbookCat, //Textbook Catalogiue
  $request->file('Textbookfile')->store('files')); // Use the appropriate import class

 $fileNameTextB = "Section 21 C Textbook Catalogue_".uniqid() . '_' . $TextbookFile->getClientOriginalName();

  $destinationPath='public/ApprovePdf';   
  //$file->move( $destinationPath, $fileName);
 $TextbookFile->move($destinationPath, $fileNameTextB);
   
  $Descript2 = "SECTION 21C TEXTBOOK CATALOGUE FOR THE YEAR ".date('Y');
 DB::connection('itrfurns')->table('alloctionfunddata')->insert([
     'Description' => $Descript2,
    'file' => $fileNameTextB,
 ]);

  return redirect()->back()->with('success', 'Data imported successfully.');
}


public function uploadstat(Request $request){

  $StationaryFile = $request->file('Stationaryfile');

   Excel::import(new ImportStationary, //Textbook Catalogiue
  $request->file('Stationaryfile')->store('files')); // Use the appropriate import class

  $fileNameStatB = "Section 21 C Stationary Catalogue_".uniqid() . '_' . $StationaryFile->getClientOriginalName();

   $destinationPath='public/ApprovePdf';   
   //$file->move( $destinationPath, $fileName);
   $StationaryFile->move($destinationPath, $fileNameStatB);
   
    $Descript2 = "SECTION 21C STATIONERY CATALOGUE FOR THE YEAR ".date('Y');
  DB::connection('itrfurns')->table('alloctionfunddata')->insert([
      'Description' => $Descript2,
     'file' => $fileNameStatB,
  ]);

  return redirect()->back()->with('success', 'Data imported successfully.');
}


public function action2(Request $request){
  // Specify the database connection you want to use
  $id= $request->input('del');

  $descriptVal = $request->input("Descript");


  if($descriptVal === "SECTION 21C FUNDS ALLOCATION FOR THE YEAR 2023"){
    $connection = 'itrfurns';

    // // The name of the table you want to delete records from
    $table = 'alloctionfunddata';
    $tables = 'allocationfunds';
  
    //Perform the delete operation for the record with the specified ID
  
     DB::connection($connection)->table($table)->where('id', $id)->delete();
   DB::connection($connection)->table($tables)->delete();

   return redirect()->back()->with('successD', 'Data Deleted Sucessfully.');

  
  }else if($descriptVal === "SECTION 21C STATIONERY CATALOGUE FOR THE YEAR 2023"){
    $connection = 'itrfurns';

    $table = 'alloctionfunddata';
    $tables = 'stationarycat';

    DB::connection($connection)->table($table)->where('id', $id)->delete();

    DB::table($tables)->delete();

    return redirect()->back()->with('successD', 'Data Deleted Sucessfully.');

  }else if($descriptVal === "SECTION 21C TEXTBOOK CATALOGUE FOR THE YEAR 2023"){
    $connection = 'itrfurns';

    $table = 'alloctionfunddata';
    $tables = 'textbookcat';

    DB::connection($connection)->table($table)->where('id', $id)->delete();

    DB::table($tables)->delete();

    return redirect()->back()->with('successD', 'Data Deleted Sucessfully.');
  }

  





}


public function MarkAsRead(Request $request){
  $id = $request->input('DelS');

  DB::table('inbox')
  ->where('Id', $id)

  ->update([
      'seen' => "1",

  ]);

  return redirect()->back()->with('successD', 'Data Deleted Sucessfully.');


}

public function DeleteMessage(Request $request){
  $id = $request->input('del');

  DB::table('inbox')
  ->where('Id', $id)

  ->update([
      'DelVal' => "1",

  ]);

  return redirect()->back()->with('successD', 'Data Deleted Sucessfully.');

}


// public function import(Request $request){
//     Excel::import(new ImportUser, 
//                   $request->file('file')->store('files'));
//     return redirect()->back();
// }


}

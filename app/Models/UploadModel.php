<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;


class UploadModel extends Model
{

    protected $connection = 'itrfurns'; // Specify the desired database connection

    use HasFactory;
//INSERT INTO `allocationfunds`(`Id`, `EMIS`, `TEXTBOOK ALLOCATION`, `STATIONERY ALLOCATION`, `OTHER LTSM`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    protected $table = 'allocationfunds'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id', 'EMIS', 'TEXTBOOK ALLOCATION', 'STATIONERY ALLOCATION', 'OTHER LTSM', 'updated_at', 'created_at'];

    // public function model(array $row)
    // {
        
    //     $emis = '500' . $row[1];


    //     return new UploadModel([
    //        'Id' => $row[0],
    //         'EMIS' => $emis,
    //         'TEXTBOOK ALLOCATION' => $row[2],
    //         'STATIONERY ALLOCATION' => $row[3],
    //         'OTHER LTSM' => $row[4],

    //     ]);
    // }
}

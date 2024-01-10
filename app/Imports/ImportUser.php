<?php
 
namespace App\Imports;
 
use App\Models\UploadModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
 
class ImportUser implements ToModel , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $emis = '500' . $row[1];
 
        return new UploadModel([
         'Id' => $row[0],
            'EMIS' => $emis,
            'TEXTBOOK ALLOCATION' => $row[2],
            'STATIONERY ALLOCATION' => $row[3],
            'OTHER LTSM' => $row[4],
 
        ]);
        
    }

        // Specify the row to start importing (in your case, skip the first row with the headers)
        public function startRow(): int
        {
            return 2; // Skip the first row (header) and start importing from the second row.
        }
}
 
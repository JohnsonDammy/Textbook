<?php

namespace App\Imports;

use App\Models\User;
use App\Models\TextbookModelCatologue;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;



class ImportTextbookCat implements ToModel , WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //INSERT INTO `textbookcat`(`id`, `CatType`, `Grade`, `Header`, `Subject`, `Language`, `Language_Level`, `Publisher`, `Title`, `ISBN`, `Component`, `Price`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]')
        

     
//C:\Users\Damilare.Oloko\Pictures\Textbook\app\Imports
        return new TextbookModelCatologue([
            'id' => $row[0], 
            'Publisher' => $row[1],
            'Header' => $row[2],
            'Subject' => $row[3],
            'Language' => $row[4],
            'Language_Level' => $row[5],
            'Grade' => $row[6],
            'Title' => $row[7],
            'ISBN' => $row[8],
            'Component' => $row[9],
            'Price' => $row[10],
            'CatType' => $row[11],
        ]);
    }

      // Specify the row to start importing (in your case, skip the first row with the headers)
      public function startRow(): int
      {
          return 2; // Skip the first row (header) and start importing from the second row.
      }
}

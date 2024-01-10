<?php

namespace App\Imports;

use App\Models\StationaryModelCatalogue;
use Maatwebsite\Excel\Concerns\ToModel;


use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportStationary implements ToModel , WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
 //INSERT INTO `stationarycat`(`id`, `ItemCode`, `Item`, `Quantity`, `UnitPrices`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

        return new StationaryModelCatalogue([
            //
            'id' => $row[0],
            'ItemCode' => $row[1],
            'Item' => $row[2],
            'Quantity' => $row[3],
            'UnitPrices' => $row[4],


        ]);
    }

    // Specify the row to start importing (in your case, skip the first row with the headers)
    public function startRow(): int
    {
        return 2; // Skip the first row (header) and start importing from the second row.
    }
}

<?php

namespace App\Imports;

use App\Models\Refuelling;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class RefulleingDataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
     
        return new Refuelling([
            'fleet_id' => 1,
            'machine_hours' => (float) trim($row[1], 'h'),
            'fuel_added' => (float) trim($row[2], 'L'),
            'location' => 'Unkown',
            'isTankFilled' => isset($row[1]) ? 1 : 0,
            'date' => Carbon::createFromFormat('m/d/Y', $row[0]),
        ]);
    }
}

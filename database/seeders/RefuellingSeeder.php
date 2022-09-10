<?php

namespace Database\Seeders;

use App\Models\Fleet;
use App\Models\Refuelling;
use App\Imports\RefulleingDataImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RefuellingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Excel::import(new RefulleingDataImport, public_path() . '/refuellings.csv');
    }
}

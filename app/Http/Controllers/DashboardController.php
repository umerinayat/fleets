<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\Refuelling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index() {

        // financial Year
        $startDate = '2019-07-01';
        $endDate = '2020-06-30';
 
        $data = [];

        $data['fleets'] = Fleet::orderBy('created_at', 'DESC')->get();

        $AllfyrRefulellings = Refuelling::whereDate('date', '>=', $startDate)
        ->whereDate('date', '<=', $endDate)->get();

        $totalFuelConsumption = $AllfyrRefulellings->sum('fuel_added');

        $fyrRefulellings = Refuelling::whereDate('date', '>=', $startDate)
        ->whereDate('date', '<=', $endDate)
        ->where('isTankFilled', 1)
        ->where('fleet_id', 1)
        ->orderBy('id', 'ASC')
        ->get();

        $hoursDifference = $fyrRefulellings->map(function($refuel, $key) use ( $fyrRefulellings ) {
            if(isset($fyrRefulellings[ $key + 1])) {
              
               $h = abs((float) $refuel->machine_hours - (float) $fyrRefulellings[ $key + 1]->machine_hours);

                return [
                    'litterPerHour' =>  $h == 0 ? 0 : $fyrRefulellings[ $key + 1]->fuel_added /  $h,
                    'l' => $fyrRefulellings[ $key + 1]->fuel_added,
                    'h' => $h
                ];
            }
        });

        unset($hoursDifference[count($hoursDifference) - 1]);

       $littersPerHours = $hoursDifference->pluck('litterPerHour');

        // dd( count( $littersPerHours),  $hoursDifference);

        $operatingHours = $fyrRefulellings->max('machine_hours') - $fyrRefulellings->min('machine_hours');
        $currentMachineReading = $fyrRefulellings->max('machine_hours');

        $data['operatingHours'] = $operatingHours;
        $data['currentMachineReading'] = $currentMachineReading;
        $data['totalFuelConsumption'] = $totalFuelConsumption;
        $data['littersPerHours'] = $littersPerHours->avg();
       
        return view('dashboard', $data);
    }
}



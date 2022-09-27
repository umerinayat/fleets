<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\Refuelling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DataTables;

class DashboardController extends Controller
{
    public function index(Request $request) {

        $data = [];

        $fleets = Fleet::orderBy('created_at', 'DESC')->get();
        
        $data['fleets'] = $fleets;

        if ( $request->ajax() ) 
        {
                // d.isFilter = isFilter;
            // d.sdate = startDate.value;
            // d.edate = endDate.value;
            // d.sfleet = sfleet.value


            // financial Year
            $startDate =  $request->sdate;
            $endDate =  $request->edate;

            if(isset($request->sfleet)) {
                $fleetId = $request->sfleet;
                $fleets = $fleets->where('id', $fleetId);
            } 

            // financial Year
            // $startDate = '2019-07-01';
            // $endDate = '2020-06-30';

            $readings = [];

            foreach($fleets as $fleet) {
    
                $AllfyrRefulellings = Refuelling::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('fleet_id', $fleet->id)
                ->get();
    
                $totalFuelConsumption = $AllfyrRefulellings->sum('fuel_added');
    
                $fyrRefulellings = Refuelling::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('isTankFilled', 1)
                ->where('fleet_id', $fleet->id)
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
    
                
                $operatingHours = $fyrRefulellings->max('machine_hours') - $fyrRefulellings->min('machine_hours');
                $currentMachineReading = $fyrRefulellings->max('machine_hours');
    
                array_push($readings, [
                    'fleet_name'   => $fleet->name,
                    'fleet_number' => $fleet->fleet_number,
                    'operatingHours' => $operatingHours,
                    'currentMachineReading' => $currentMachineReading,
                    'totalFuelConsumption' => $totalFuelConsumption,
                    'littersPerHours' => $littersPerHours->avg(),
                ]);
            }
    
            $rows = collect($readings);

            return Datatables::of($rows)->addIndexColumn()
                ->addColumn('currentMachineReading', function($row){
                    return $row['currentMachineReading'] == null ? number_format(0, 1, '.', '') : number_format($row['currentMachineReading'], 1, '.', '');
                })
                ->addColumn('operatingHours', function($row){
                    return $row['operatingHours'] == null ? number_format(0, 1, '.', '') : number_format($row['operatingHours'], 1, '.', '');
                })
                ->addColumn('totalFuelConsumption', function($row){
                    return number_format($row['totalFuelConsumption'], 2, '.', '');
                })
                ->addColumn('littersPerHours', function($row){
                    return number_format($row['littersPerHours'], 1, '.', '');
                })
               
                ->rawColumns(['currentMachineReading', 'totalFuelConsumption', 'littersPerHours', 'operatingHours'])
                ->make(true);
        }
        
        return view('dashboard', $data);
    }
}



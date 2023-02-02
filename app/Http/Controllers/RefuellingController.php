<?php

namespace App\Http\Controllers;

use App\Http\Requests\Refuelling\StoreRefuelling;
use App\Http\Requests\Refuelling\UpdateRefuelling;
use App\Models\Refuelling;
use App\Models\Fleet;
use Illuminate\Http\Request;
use DataTables;

class RefuellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $fleets = Fleet::orderBy('created_at', 'DESC')->get();
        
        $data['fleets'] = $fleets;

        if ( $request->ajax() ) 
        {
            $refuellings = Refuelling::whereHas('fleet')->with('fleet')->orderBy('id', 'DESC');
            return Datatables::of($refuellings)->addIndexColumn()
                ->addColumn('action', function($row){
                    $buttons = "<span style='font-size:1.6em;color:green' class='mdi mdi-square-edit-outline edit-ref-btn c-icon'  data-id='$row->id' id='$row->id'></span>";
                    $buttons .= "<span style='font-size:1.6em;color:red' class='mdi mdi-trash-can-outline ml-2 delete-ref-btn c-icon'  data-id='$row->id' id='$row->id'></span>";

                    return $buttons;
                })
                ->addColumn('isTankFilled', function($row){
                    return $row->isTankFilled == 1 ? 'YES' : 'NO';
                })
                ->addColumn('fleet_number', function($row){
                    return $row->fleet->fleet_number;
                })
                ->addColumn('fleet_name', function($row){
                    return $row->fleet->name;
                })
                ->rawColumns(['action', 'fleet_number' ,'fleet_name', 'isTankFilled'])
                ->make(true);
        }

        return view('refuellings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefuelling $request)
    {

        $isTankFilled = $request->has('isTankFilled') ? 1 : 0;

        $refuelling = Refuelling::create([
            'fleet_id' => $request->fleet_id,
            'machine_hours' => $request->machine_hours,
            'fuel_added' =>  $request->fuel_added,
            'location' => $request->location,
            'date' => $request->date,
            'isTankFilled' => $isTankFilled
        ]);

        return [
            'success' => true,
            'message' => 'New Refuelling Added',
            'refuelling' => $refuelling
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refuelling  $refuelling
     * @return \Illuminate\Http\Response
     */
    public function show(Refuelling $refuelling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Refuelling  $refuelling
     * @return \Illuminate\Http\Response
     */
    public function edit(Refuelling $refuelling)
    {
        return ['success' => true, 'refuelling' => $refuelling];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refuelling  $refuelling
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRefuelling $request, Refuelling $refuelling)
    {
        $isTankFilled = $request->has('isTankFilled') ? 1 : 0;

        $refuelling->update([
            'fleet_id' => $request->fleet_id,
            'machine_hours' => $request->machine_hours,
            'fuel_added' =>  $request->fuel_added,
            'location' => $request->location,
            'date' => $request->date,
            'isTankFilled' => $isTankFilled
        ]);

        return [
            'success' => true,
            'message' => 'Refuelling Updated',
            'refuelling' => $refuelling
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Refuelling  $refuelling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refuelling $refuelling)
    {
        $refuelling->delete();

        return [
            'success' => true,
            'message' => 'Refuelling Deleted!',
            'deletedRefuelling' => $refuelling,
        ];
    }
}

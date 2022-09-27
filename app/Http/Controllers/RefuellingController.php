<?php

namespace App\Http\Controllers;

use App\Http\Requests\Refuelling\StoreRefuelling;
use App\Http\Requests\Refuelling\UpdateRefuelling;
use App\Models\Refuelling;
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
        if ( $request->ajax() ) 
        {
            $refuellings = Refuelling::whereHas('fleet')->with('fleet');
            return Datatables::of($refuellings)->addIndexColumn()
                ->addColumn('action', function($row){
                    $id =  $row->id;
                    $token = csrf_token();
                    $formId = "'form'";
                    $editIcon = '<i class="fa-solid fa-pen edit-icon icon"></i><form style="display:inline" method="post" action="/refuelling/'.$id.'"><i onclick="this.closest('.$formId.').submit();" class="fa-solid fa-trash trash-icon icon"></i><input type="hidden" name="_token" value="'.$token.'"><input type="hidden" name="_method" value="delete"></form>';
                    return $editIcon;
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

        return view('refuellings.index');
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

        Refuelling::create([
            'fleet_id' => $request->fleet_id,
            'machine_hours' => $request->machine_hours,
            'fuel_added' =>  $request->fuel_added,
            'location' => $request->location,
            'date' => $request->date,
            'isTankFilled' => $isTankFilled
        ]);

        return redirect('/');
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
        //
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
        //
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

        return redirect('/refuelling');
    }
}

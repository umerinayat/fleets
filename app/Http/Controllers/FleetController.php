<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fleet\StoreFleet;
use App\Http\Requests\Fleet\UpdateFleet;
use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;

class FleetController extends Controller
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
            $fleets = Fleet::select('id','fleet_number','name', 'image_url');
            return Datatables::of($fleets)->addIndexColumn()
                ->addColumn('action', function($row){
                    $editIcon = '<i class="fa-solid fa-pen edit-icon icon"></i><i class="fa-solid fa-trash trash-icon icon"></i>';
                    return $editIcon;
                })
                ->addColumn('image', function($row){
                    $image_url = $row->image_url;
                    $img = "<img width='50px' height='50px' src='$image_url' class='' />";
                    return $img;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('fleets.index');
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
    public function store(StoreFleet $request)
    {
        $imageName = $request->file('image')->getClientOriginalName();

        $path = '/uploads/fleets/images/'.time().'-'.$imageName;
        Storage::disk('public')->put($path, $request->file('image')->getContent());

        $image_url = Storage::url($path);

        Fleet::create([
            'fleet_number' => $request->fleet_number,
            'name' => $request->name,
            'image_url' => $image_url
        ]);

        return redirect('/fleets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function show(Fleet $fleet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function edit(Fleet $fleet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFleet $request, Fleet $fleet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fleet $fleet)
    {
        //
    }
}

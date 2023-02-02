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

        if (request()->ajax()) {
            $fleets = Fleet::select('id', 'fleet_number', 'name', 'image_url')->orderBy('id', 'DESC');

            return DataTables::of($fleets)
                ->addColumn('image', function ($fleet) {
                    $image_url = $fleet->image_url;
                    $img = "<img width='50px' height='50px' src='$image_url' class='' />";
                    return $img;
                })
                ->addColumn('action', function ($fleet) {

                    $buttons = "<span style='font-size:1.6em;color:green' class='mdi mdi-square-edit-outline edit-fleet-btn c-icon'  data-id='$fleet->id' id='$fleet->id'></span>";
                    $buttons .= "<span style='font-size:1.6em;color:red' class='mdi mdi-trash-can-outline ml-2 delete-fleet-btn c-icon'  data-id='$fleet->id' id='$fleet->id'></span>";

                    return $buttons;
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
        try {

            $image = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

            $imageFile = \Image::make($request->image);

            $path = '/uploads/fleets/images/' . $image;

            Storage::disk('public')->put($path, (string) $imageFile->encode());

            $image_url = Storage::url($path);

            $fleet = Fleet::create([
                'fleet_number' => $request->fleet_number,
                'name' => $request->name,
                'image_url' => $image_url
            ]);

            return [
                'success' => true,
                'message' => 'New Fleet Added',
                'fleet' => $fleet
            ];

        } catch (\Exception $e) {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function show(Fleet $fleet)
    {
        return response()->json([
            'fleet' => $fleet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function edit(Fleet $fleet)
    {
        return ['success' => true, 'fleet' => $fleet];
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
        $fleet->update([
            'fleet_number' => $request->fleet_number,
            'name' => $request->name
        ]);

        return [
            'success' => true,
            'message' => 'Fleet Updated',
            'fleet' => $fleet
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fleet $fleet)
    {
        $fleet->delete();

        return [
            'success' => true,
            'message' => 'Fleet Deleted!',
            'deletedFleet' => $fleet,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
            $users = User::orderBy('id', 'DESC');
            return Datatables::of($users)->addIndexColumn()
                ->addColumn('action', function($row){
                    $id =  $row->id;
                    $token = csrf_token();
                    $formId = "'form'";
                    if( ! $row->hasRole('admin') ) {
                        $editIcon = '<i class="fa-solid fa-pen edit-icon icon"></i><form style="display:inline" method="post" action="/users/'.$id.'"><i onclick="this.closest('.$formId.').submit();" class="fa-solid fa-trash trash-icon icon"></i><input type="hidden" name="_token" value="'.$token.'"><input type="hidden" name="_method" value="delete"></form>';
                        return $editIcon;
                    } else {
                        return 'Admin';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
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
    public function store(StoreUser $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);   

        $role = Role::findByName($request->role);

        $user->assignRole($role);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users');
    }
}

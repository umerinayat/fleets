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
                    
                    $buttons = '';

                    if( ! $row->hasRole('admin') ) {
                        $buttons .= "<span style='font-size:1.6em;color:red' class='mdi mdi-trash-can-outline ml-2 delete-user-btn c-icon'  data-id='$row->id' id='$row->id'></span>";
                    } 

                    $buttons .= "<span style='font-size:1.6em;color:green' class='mdi mdi-square-edit-outline edit-user-btn c-icon ml-2'  data-id='$row->id' id='$row->id'></span>";

                    return $buttons;
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

        return [
            'success' => true,
            'message' => 'New User Added',
            'user' => $user
        ];
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
        return [
            'success' => true,
            'message' => 'Fleet Updated',
            'user' => $user->load('roles')
        ];
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
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);   

        // $role = Role::findByName($request->role);

        $user->syncRoles([$request->role]);

        return [
            'success' => true,
            'message' => 'User Updated',
            'user' => $user
        ];
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

        return [
            'success' => true,
            'message' => 'User Deleted!',
            'deletedUser' => $user,
        ];
    }
}

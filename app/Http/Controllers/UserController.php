<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_users = DB::table('users')->get();
        return view('users.users',compact('all_users'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_user = DB::table('users')->where('id',$id)->first();
        return view('users.edit',compact('edit_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->location = $request->input('location');
        $users->contact = $request->input('contact');
        $users->role = $request->input('role');
        $users->update();
        return redirect()->route('users.index')->with('status','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_photo = User::where('id',$id)->first();

        $fileloc = 'app/public/profile_photo/'.$user_photo->profile_photo_path;
        $filename = storage_path($fileloc);
        //dd($filename);

        if(File::exists($filename)) {
            File::delete($filename);
        }
        $user_delete = DB::table('users')->where('id',$id)->delete();
        return redirect()->back()->with('status', 'The User Has Been Deleted Successfully');
    }
}

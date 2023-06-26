<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCredentials;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string'],
            'contact' => ['required', 'integer', 'min:10'],
            'role'=>'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //calling function to autogenerate a strong password
        $password = $this->generateStrongPassword(12);

        //create new user
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'contact' => $request['contact'],
            'role'=>$request['role'],
            'location' => $request['location'],
            'password' => Hash::make($password),
        ]);
        

        //Send an Email which includes the UserCredentials
        $name = $request['name'];
        $user = User::latest()->first();
        $this->sendUserCredentials($user, $password);

        return redirect()->route('users.index')->with('status','User Added Successfully');
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

    function generateStrongPassword($length = 12) {
        // Define the characters to be used in the password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|';
        // Get the total number of characters
        $characterCount = strlen($characters);
        // Initialize the password variable
        $strongPassword = '';
        // Generate random characters to form the password
        for ($i = 0; $i < $length; $i++) {
            $strongPassword .= $characters[rand(0, $characterCount - 1)];
        }
        return $strongPassword;
    }

    public function sendUserCredentials($user, $password)
    {
        //Mail Notification
        $userCreatedNow = [
            'body' => 'User Credentials From MCTS
                Hello '.$user->name.', Your Accout has been Created Successfully.
                To login use the credentials below.
                Email: '.$user->email.'
                Password: '.$password,
                
            'message' => 'Go to login',
            'url' => url('/login'),
            'thankyou' => 'Welcome to MCTS. Bye bye to worring about your child.'
        ];
        Notification::sendNow($user, new UserCredentials($userCreatedNow));

        return;
    }
}

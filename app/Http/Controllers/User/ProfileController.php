<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = User::with('student')->findOrFail($id);
        $this->authorize($user);
        return view('user.profile.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        $userToEdit = User::findOrFail($id);
        $this->authorize($userToEdit);
        $validatedData = $request->validated();

        if($request->hasFile('avatar')){
            $img_path = $request->file('avatar')->store('avatars');
            
            if( isset($userToEdit->img_path) ){
                Storage::delete($userToEdit->img_path);
                $userToEdit->img_path = $img_path;
            }else{
                $userToEdit->img_path = $img_path;
            }
        }

        
        if(!empty($validatedData['password'])){
            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            $userToEdit->password = $password;
        }        
        $userToEdit->name = $validatedData['name'];
        $userToEdit->email = $validatedData['email'];
        $userToEdit->save();

        //EDIT STUDENT MODEL 
        $userToEdit->student->guardian = $validatedData['guardian'];
        $userToEdit->student->contact_number = $validatedData['contact_number'];
        $userToEdit->student->address = $validatedData['address'];

        $userToEdit->student->save();

        return redirect()->back()->with('status', 'Your profile was successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

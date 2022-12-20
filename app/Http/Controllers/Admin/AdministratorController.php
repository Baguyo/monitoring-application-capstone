<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminCreation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdministrator;
use App\Http\Requests\UpdateAdministrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdministratorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:admin');
        $this->authorizeResource(User::class, 'user');
    }



 


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit( User $user)
    {
        return view('admin.administrator.edit',['admin'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrator $request, User $user)
    {
        

        $validatedData = $request->validated();
        if(!empty($validatedData['password'])){
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user->update([
                'name' => $validatedData['name'],
                'password' => $validatedData['password'],
            ]);
        }else{
            $user->update([
                'name' => $validatedData['name'],
            ]);
        }
        return redirect()->back()->with('status', "Your profile was successfully updated" );

        // if($request->hasFile('avatar')){
        //     $img_path = $request->file('avatar')->store('avatars');
            
        //     if( isset($user->img_path) ){
        //         Storage::delete($user->img_path);
        //         $user->img_path = $img_path;
        //     }else{
        //         $user->img_path = $img_path;
        //     }
        // }
    }

    
    
}

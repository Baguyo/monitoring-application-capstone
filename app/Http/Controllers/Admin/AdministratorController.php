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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrator = Cache::remember('allAdmin', 60 , function(){
            // return User::where('type', '=', '1')->get();
            return DB::table('users')
                        ->select(['*'])
                        ->where('type', '=', '1')->get();
        });

        // dd($administrator);
        return view('admin.administrator.index', ['administrator'=>$administrator]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.administrator.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdministrator $request)
    {

        Cache::forget('allAdmin');
        $validatedData = $request->validated();

        $new_admin = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'type' => 1
        ]);

        $new_admin->save();
        event( new AdminCreation($new_admin) );

        return redirect()->route('admin.users.index')->with('status', "New Administrator $new_admin->name was successfully created" );
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
        
        Cache::forget('allAdmin');

        $validatedData = $request->validated();

        if($request->hasFile('avatar')){
            $img_path = $request->file('avatar')->store('avatars');
            
            if( isset($user->img_path) ){
                Storage::delete($user->img_path);
                $user->img_path = $img_path;
            }else{
                $user->img_path = $img_path;
            }
        }
        
        
        if(!empty($validatedData['password'])){
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);
        }else{
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);
        }
        // return redirect()->route('admin.users.index')->with('status', "New Administrator $user->name was successfully updated" );
        return redirect()->back()->with('status', "Your profile was successfully updated" );

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   
        if( isset($user->img_path)){
            Storage::delete($user->img_path);
        }
        $user->delete();
        return redirect('/');
    }
}

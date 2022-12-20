<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactMessage;
use App\Mail\NotifyAdminContactUsMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:user');
    }

    public function create(){
        return view('user.contact.create');
    }

    public function messageSend( SendContactMessage $request ){
        $validatedData = $request->validated();

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(
            new NotifyAdminContactUsMessage($validatedData['message']),
        );

        return redirect()->route('user.contact.create')->with('status','Message succesfully sent');
    }
}

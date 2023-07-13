<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use app\Models\Patient;

class HomeController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth'); //check if user has login
    }
    public function redirects(){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            return redirect()->route('patient.profile');
        }
        elseif($usertype == '1'){
            return redirect()->route('doctor.profile');
        }
        elseif($usertype == '2'){
            return redirect()->route('admin.dashboard');
        }
    }
}

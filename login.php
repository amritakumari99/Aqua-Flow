<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
class login extends Controller
{
    function loginPage(Request $req){
        return view('userviews.landing.login');
    }
    function user_login(Request $req){
        $req->validate([
            'contactNo' => 'required|min:10|max:13',
            'password' => 'required|min:8'
        ]);
        $contactNo = $req->input('contactNo');
        $password = $req->input('password');
        $user = DB::table('alluser')->where('contactNo', $contactNo)->first();

        if (($contactNo == $user->contactNo) && ($password == $user->password)) {
            $req->Session()->put('loginId', $user->id);
            return redirect('userdashboard')->with('success', 'congratuletions you have success-fully logged in');
        } else {
            return back()->with('fail', 'there are email or password are incorract');
        }
    }
    function logout(Request $req){
        $req->session()->forget('loginId');
        return view('userviews.landing.index')->with('success', 'You have been logged out successfully.');

    }
}

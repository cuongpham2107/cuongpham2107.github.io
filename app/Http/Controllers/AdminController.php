<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return Redirect::to('admin.dashboard');
        }else {
           return Redirect::to('admin')->send();

        }
    }
    public function index(){
    	return view('admin_login');
    }

    public function show_dashboard(){
        $this->Authlogin();
    	return view('admin.dashboard');
    }

    public function dashboard(Request $request){

    	$admin_email =  $request->admin_email;
    	$admin_password = MD5($request->admin_password);

    	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        // echo '<pre>';
        // print_r($result);
        //return view('admin.dashboard');
        // echo '</pre>';

        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        }else {
            Session::put('message', 'Mật khẩu và Tài Khoản bị sai');
            return Redirect::to('/admin');
        }

    }
    public function log_out(){
        $this->Authlogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');

    }
}

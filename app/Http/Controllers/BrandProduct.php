<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return Redirect::to('admin.dashboard');
        }else {
           return Redirect::to('admin')->send();

        }
    }
    public function add_brand_product(){
        $this->Authlogin();
        return view('admin.add_brand_product');

    }
    public function all_brand_product(){
        $this->Authlogin();
        $all_brand_product = DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);


         return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);

    }
    public function save_brand_product(Request $request){
        $this->Authlogin();
        $data = array();//lay du lieu tu admin nhap
        $data['brand_name']=$request->brand_product_name;
        $data['brand_desc']=$request->brand_product_desc;
        $data['brand_status']=$request->brand_product_status;

        // print_r($data);
        DB::table('tbl_brand')->insert($data);//insert du lieu

        Session::put('message','Them thuong hieu san pham thanh cong');
        return Redirect::to('add-brand-product');
    }

    public function unactive_brand_product($brand_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Không kích hoạt thuong hieu sản phẩm thành công');
        return Redirect::to('all-brand-product');

    }
    public function active_brand_product($brand_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','kích hoạt thuong hieu sản phẩm thành công');
        return Redirect::to('all-brand-product');
}

    public function edit_brand_product($brand_product_id){
        $this->Authlogin();
        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);


         return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);

    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->Authlogin();
        $data = array();
        $data['brand_name']=$request->brand_product_name;
        $data['brand_desc']=$request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);//update du lieu
        Session::put('message','Cập nhập thuong hieu sản phẩm thành công');
        return Redirect::to('all-brand-product');


    }
    public function delete_brand_product($brand_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();//update du lieu
        Session::put('message','Xoa thuong hieu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
}

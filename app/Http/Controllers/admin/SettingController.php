<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Hash;

class SettingController extends Controller
{
    public function index(){
        $data['settings'] = SettingModel::findOrFail(1);
        return admin_view('setting',$data);
    }
    public function change_password(Request $request){
        if($request->isMethod('post')){
            $user = Auth::user();
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:5',
            ]);
            if ($validator->fails()) {
                $errors = validation_errors_message($validator->errors()->messages());
                echo json_encode($errors);
                exit;
            }
            if (!Hash::check($request->current_password, $user->password)) {
                $error[][0] = 'Current password is incorrect';
                $errors = validation_errors_message($error);
                echo json_encode($errors);
                exit;
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_password'),'redirect'=>route('change_password'));
            echo json_encode($validation_success);
            exit;
        }

        return admin_view('change_password',[]);
    }
    public function update(Request $request){
        
        $image                  =   $request->file('logo');
        $setting                =   SettingModel::find(1);
        $setting->title         =   $request->title;
        if(!empty($image)){
            $imageUrl           =   upload_img($image,'img/logo/');
            $setting->logo      =   $imageUrl;
        }
        $setting->mobile_number =   $request->mobile_number;
        $setting->email         =   $request->email;
        $setting->editorial_board    =   $request->editorial_board;
        $setting->editorial_process    =   $request->editorial_process;
        $setting->submit_article_text    =   $request->submit_article_text;
        $setting->copy_right    =   $request->copy_right;
        $setting->save();

        $validation_success = array('success'=>1,'message'=>__('message.upd_setting'),'redirect'=>route('setting'));
        echo json_encode($validation_success);
        exit;
    }
}

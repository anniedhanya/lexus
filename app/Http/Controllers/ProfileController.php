<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth,View,Redirect,Hash,Carbon\carbon;
use App\User,App\UserDetail;
use Illuminate\Http\Request;

class ProfileController extends Controller {


    function changePassword(){ 
       return View::make('Admin.login.password');
    }
    protected function newPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'password' => 'required',
           'new_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/|min:8|max:20',
           'confirm_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/|min:8|max:20|same:new_password'
        ],[
           'password.required' =>'The current password field is required',
           'confirm_password.required' =>'The confirm new password field is required.',
           'new_password.regex'=>'The new Password should have at least one small letter, one capital letter, and one number. Password should be minimum of 8 letters/numbers',
           'confirm_password.regex'=>'The confirm Password should have at least one small letter, one capital letter, and one number. Password should be minimum of 8 letters/numbers'
        ]);
        if ($validator->passes()) {
            try {
                $user = Auth::guard('admin')->user();
                if (Hash::check($request->password, $user->password)) {
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    return Redirect::back()->with('successmsg', 'Password Changed Successfully.');
                }
                return Redirect::back()->withInput()->with('errormsg', 'Current password you entered is incorrect.');;
            } catch (\Exception $e) {
                return Redirect::back()->withInput()->withError($e->getMessage());
            }
        }
        return Redirect::back()->withInput()->withErrors($validator->messages());

    }

    function changeEmail(){ 
       return View::make('Admin.login.changeEmail');
    }

     protected function newEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'new_email' => 'required|email|max:150|unique:cpo_users,email',
           'confirm_email' => 'required|email|max:150|unique:cpo_users,email|same:new_email',
        ],[
           'new_email.required' =>'The new email address field is required',
           'confirm_email.required' =>'The confirm email address field is required.'
           
           
        ]);
        if ($validator->passes()) {
            try {
                $user = Auth::guard('admin')->user();
                if ($request->new_email) {
                    $user->email =$request->new_email;
                    $user->save();
                    return Redirect::back()->with('successmsg', 'Email Changed Successfully.');
                }
            } catch (\Exception $e) {
                return Redirect::back()->withInput()->withError($e->getMessage());
            }
        }
        return Redirect::back()->withInput()->withErrors($validator->messages());

    }

      function profile(){ 
        $userData=Auth::guard('admin')->user();
       return View::make('Admin.login.profile',['data' => $userData]);
    }

        protected function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|max:150',
           'email' => 'required|email|max:150|unique:users,email,'.Auth::guard('admin')->user()->id,
           'mobile_number' => 'required|min:9|max:15'
        ],[
           'name.required' =>'The Name field is required',
           'name.max' =>'The Name must not be greater than 150 characters.'
           
        ]);
        if ($validator->passes()) {
            try {
                $user = Auth::guard('admin')->user();
                if ($request) {
                    $user->name =$request->name;
                    $user->email =$request->email;
                    $user->mobile_number =$request->mobile_number;
                    $user->save();
                    return Redirect::back()->with('successmsg', 'Profile Updated Successfully.');
                }
            } catch (\Exception $e) {
                return Redirect::back()->withInput()->withError($e->getMessage());
            }
        }
        return Redirect::back()->withInput()->withErrors($validator->messages());

    }



}
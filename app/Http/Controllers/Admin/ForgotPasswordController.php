<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Notifications\Notifiable;
use View,Mail,Auth,Str;
use Illuminate\Support\Facades\Validator;
// namespace Illuminate\Auth\Passwords;
// use Illuminate\Contracts\Auth\PasswordBroker;
// use Illuminate\Foundation\Auth\ResetsPasswords;
// use Illuminate\Http\Request;
use App\Models\Users;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest-admin');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
    protected function validateEmail(Request $request)
    {
       
       
        //$this->validate($request, ['email' => 'required|email']);
         $this->validate($request, ['email' => 'exists:cpo_users,email'],['email.exists' =>'Entered email is not registered']);
    }

    public function userForgotPassword()
    {

       $data = [];
        return View::make('passwords.email', $data);
    }

    public function forgotPassword(Request $request)
    {
      
        $data['error'] = [];
        $data['msg'] = [];
        $data['email'] = null;
        $inputData = $request->all();  
 
        $rules = [
            'email' => 'required|email',
        ];

        $messages = [
            'email.required' => 'Email Address is required.',
            'email.email' => 'Invalid Email Address.',
            'email.exists' => 'Oops ! Admin does not exists.'
        ];
        $validator = Validator::make($inputData, $rules, $messages);

        if (!$validator->fails()) {
            $user = new Users();
            $user = $user->where('email', '=', $inputData['email'])->first();
               
            if ($user) {
                $user->remember_token = $this->getForgotPasswordToken();
                $user->save();
                
                
            $inputData['siteURL']= env('APP_URL');
            $inputData['resetPasswordURL'] = url("/admin/")
                . config('constants.USER_FORGOT_PASSWORD_RESET_URL')
                . $user->remember_token;
        
                // \Illuminate\Support\Facades\Mail::to($inputData['email'])
                //     ->queue(new \App\Mail\ForgotPasswordEmail($user));
                   
                // $datFa['msg'] = 'Password reset link has been sent to your registered email, please verify your email and proceed.';
                $current_url = url('/admin/forgot-password');
                 $mail_id = $inputData['email'];
                Mail::send('email.user_forgot_password',['inputData' => $inputData], function($message) use ($mail_id, $inputData ) {
                        $message->from('rahulpbu8593926809@gmail.com', 'Password Reset Link');
                        $message->to($mail_id)->subject('Reset Password:');
                   });
                   return redirect($current_url)->with('successmsg', 'Password reset link has been sent to your registered email, please verify your email and proceed.');
            } else {
                $data['error'] = 'Oops !Invalid email address.';
            }
        } else {
            $errors = array_map(function($errors){
                foreach($errors as $key => $value){
                    return $value;
                }
            }, $validator->errors()->messages());

            $data['error'] = $errors['email'];
            $data['email'] = $inputData['email'];
        }

        return View::make('passwords.email', $data);
    }
     protected function getForgotPasswordToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    public function renderResetPassword($token)
    {
        $data = ['token' => $token];
     
        return View::make('passwords.reset', $data);
    }

    public function resetPassword(Request $request)
    {
        $inputData = $request->all();

        $data['token'] = (!empty($inputData['token'])) ? $inputData['token'] : null;

        $rules = [
            'password' => 'required|min:8|max:20',
            'password_confirm' =>  'required|same:password',
            'token' => 'required',
        ];

        $messages = [
            'password.required' => 'Password is required.',
            'password_confirm.required' => 'Confirm Password is required',
            'token.required' => 'Token is required.',
          
        ];

        $validator = Validator::make($inputData, $rules, $messages);

        if (!$validator->fails()) {
            $user = new Users();
            $user = $user->where('remember_token', '=', $inputData['token'])->first();

            if ($user) {
                $user->password = bcrypt($inputData['password']);
                $user->remember_token = null;

                if ($user->save()) {
                     $authData = [
                    'email' => $inputData['email'],
                    'password' => $inputData['password']
                   ];

                     if (Auth::guard('admin')->attempt($authData)) {
                  return redirect('/admin/login');
                }
                    //$data['msg'] = 'Your password has been successfully changed.';
                    // return View::make('reset-password', $data);
                    // return redirect('user-login');
                }
            } else {
                $data['errors'] = ['Failed to reset your password, please try later with a valid token.'];
            }
        } else {

            $errors = array_map(function($errors){
                foreach($errors as $key => $value){
                    return $value;
                }
            }, $validator->errors()->messages());
            $data['errors'] = $errors;
        }

        return View::make('passwords.reset', $data);
    }
}

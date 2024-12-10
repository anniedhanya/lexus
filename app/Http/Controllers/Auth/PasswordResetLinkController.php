<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use View;
use Mail;
//Models
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );
        $user = User::where('email', '=', $request['email'])->first();
        $user->remember_token = $this->getForgotPasswordToken();
        $user->updated_at = Carbon::now();
        $user->save();

        $inputData['siteURL']= env('APP_URL');
        $inputData['name']= $user->name;
        $inputData['resetPasswordURL'] = url("/").'reset-password/'.$user->remember_token;
        $current_url = url('/forgot-password');
        $mail_id = $request['email']; 
        $mail_id = $request['email'];

    //   Mail::send('Mail.forgot-password',['inputData' => $inputData], function($message) use ($mail_id, $inputData ) {
    //     $message->from('info@d4media.com', 'd4media - Password reset link');
    //     $message->to($mail_id)->subject('Forgot Password Link:');
    //   });
      //return View::make('Mail.forgot-password')->with('inputData', $inputData);
        
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

protected function getForgotPasswordToken()

{
  return hash_hmac('sha256', \Str::random(12), config('app.key'));
}
public function resetPassword($token)
{
 return view('auth.reset-password',['token'=>$token]);
}

}

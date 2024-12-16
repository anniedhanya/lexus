<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repository\Interfaces\CommonRepositoryInterface;
use App\Models\CpoUsersOtp;
use App\Models\CPoUsers;
use DateTime,Auth,Mail,DB;
use App\Models\CpoSubscriptions;
use App\Models\ChargingPoint;
use App\Models\Transactions;
use App\Models\Faults;
use App\Models\Users;
use App\Models\RFIDs;
use App\Models\UserWallets;
use App\Models\Connectors;
class CommonRepository implements CommonRepositoryInterface
{
    protected $status_report;

    /**
     * Create a new repository instance.
     
     * * @author annie
     *
     * @return void
     */
    public function __construct()
    {

    }
    
     

    function sendOtp()
    {
         $otp_verification_status = Auth::guard('admin')->user()->otp_verification_status;
         if($otp_verification_status==2){
             $otp_expiry_check=CpoUsersOtp::where('cpo_users_id',Auth::guard('admin')->user()->id)->where('status',1)->first();
          if(isset($otp_expiry_check)){
             $to_date = $otp_expiry_check->created_at->toDateString();
             $from_date = date('Y-m-d'); 
             $to_date = DateTime::createFromFormat('Y-m-d', $to_date);
             $from_date = DateTime::createFromFormat('Y-m-d', $from_date);
             $interval = $to_date->diff($from_date);
             $days = $interval->format('%a');
             if($days>=7){
              $mailId =Auth::guard('admin')->user()->email;
              $fourRandomDigit = mt_rand(1000,999999);
              $uniqueNo= $fourRandomDigit;
                Mail::send('email.Login',['inputData' => $uniqueNo,'userName'=>Auth::guard('admin')->user()->business_name], function($message) use ($mailId, $uniqueNo ) {
                              $message->from('cp@nextpower.in', 'NEXT POWER');
                              $message->to($mailId)->subject('OTP');
                         });
              CpoUsersOtp::where('cpo_users_id',Auth::guard('admin')->user()->id)->where('status',1)->delete();
              $otp=new CpoUsersOtp;
              $otp['cpo_users_id']=Auth::guard('admin')->user()->id;
              $otp['otp']=$uniqueNo;
              $otp['status']=0;
              $otp->save();
              return true;
            }else{
              return false;
            }
          }
         }else{
               $to_date = Auth::guard('admin')->user()->created_at->toDateString();
               $from_date = date('Y-m-d'); 
               $to_date = DateTime::createFromFormat('Y-m-d', $to_date);
               $from_date = DateTime::createFromFormat('Y-m-d', $from_date);
               $interval = $to_date->diff($from_date);
               $days = $interval->format('%a');
               if($days==0){
                $mailId =Auth::guard('admin')->user()->email;
                $fourRandomDigit = mt_rand(1000,999999);
                $uniqueNo= $fourRandomDigit;
                Mail::send('email.Login',['inputData' => $uniqueNo,'userName'=>Auth::guard('admin')->user()->business_name], function($message) use ($mailId, $uniqueNo ) {
                              $message->from('cp@nextpower.in', 'NEXT POWER');
                              $message->to($mailId)->subject('OTP');
                         });
                CpoUsersOtp::where('cpo_users_id',Auth::guard('admin')->user()->id)->where('status',1)->delete();
                $otp=new CpoUsersOtp;
                $otp['cpo_users_id']=Auth::guard('admin')->user()->id;
                $otp['otp']=$uniqueNo;
                $otp['status']=0;
                $otp->save();
                return true;
              
               }else{
               return false;
               }  


         }
                  
     }

     function otpChecking($otp)
     {
      $cpo_user_id=Auth::guard('admin')->user()->id;
      $otp_verification=CpoUsersOtp::where('cpo_users_id',$cpo_user_id)->where('otp',$otp)->where('status',0)->first();

      if(isset($otp_verification)){
        $otp_checking=CpoUsersOtp::where('cpo_users_id',$cpo_user_id)->where('otp',$otp)->where('status',0)->where('created_at', '<', Carbon::now()->subMinutes(15)->toDateTimeString())->count();
        if($otp_checking>0){
          CpoUsersOtp::where('cpo_users_id',$cpo_user_id)->where('otp',$otp)->where('status',0)->where('created_at', '<', Carbon::now()->subMinutes(15)->toDateTimeString())->delete();
             return "OTP expired please re-send again";
        }else{
            CpoUsersOtp::where('cpo_users_id',$cpo_user_id)->where('otp',$otp)->update(['status'=>1]);
            CpoUsers::where('id',$cpo_user_id)->update(['otp_verification_status'=>2]);
              return true;
        }
      }else{
        return "Invalid OTP";
      }
  
     }

     function resendOtp($userId)
    {
         
          $mailId =CpoUsers::select('email')->where('id',$userId)->first()->email;
          $four_random_digit = mt_rand(1000,999999);
          $uniqueNo= $four_random_digit;
          Mail::send('email.resendotp',['inputData' => $uniqueNo,'userName'=>Auth::guard('admin')->user()->business_name], function($message) use ($mailId, $uniqueNo ) {
                        $message->from('cp@nextpower.in', 'NEXT POWER');
                        $message->to($mailId)->subject('Resend OTP');
                   });

          CpoUsersOtp::where('cpo_users_id',$userId)->delete();
          $otp=new CpoUsersOtp;
          $otp['cpo_users_id']=Auth::guard('admin')->user()->id;
          $otp['otp']=$uniqueNo;
          $otp['status']=0;
          $otp->save();
          return true;
                    
     }

     function cpoUserStatusCheck()
    {
      $userId = Auth::guard('admin')->user()->id;
      $subscriptionStatus=CpoSubscriptions::where('cpo_users_id',$userId)->where('start_date','<=',date('Y-m-d'))->where('status',1)->first();
      if(isset($subscriptionStatus)){
        return true;
      }else{
        return false;
      }


    }

    function getDashboardData(){
      $loginType = Auth::guard('admin')->user()->login_type;
      if($loginType==2){
        $data['live']=ChargingPoint::where('cpo_user_id',Auth::guard('admin')->user()->id)->where('status',1)->where('deleted_at','=',NULL)->count();
        $data['inactive']=ChargingPoint::where('cpo_user_id',Auth::guard('admin')->user()->id)->where('status',0)->where('deleted_at','=',NULL)->count();
        $data['total']=ChargingPoint::where('cpo_user_id',Auth::guard('admin')->user()->id)->where('deleted_at','=',NULL)->count();
      }else{
        $data['live']=ChargingPoint::where('status',1)->where('deleted_at','=',NULL)->count();
        $data['inactive']=ChargingPoint::where('status',0)->where('deleted_at','=',NULL)->count();
        $data['total']=ChargingPoint::where('deleted_at','=',NULL)->count();

      }
      if($loginType==2){
      $data['get_live_charging_section']=Transactions::join('connectors','connectors.id','=','transactions.connector_id')->where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->where('transactions.status',1)->count();
      }else{
      $data['get_live_charging_section']=Transactions::join('connectors','connectors.id','=','transactions.connector_id')->where('transactions.status',1)->count();
      }

      if($loginType==2){
      $data['total_charging_section']=Transactions::select('transactions.id')->join('connectors','connectors.id','=','transactions.connector_id')->where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->count();
      $data['total_faults']=Faults::select('faults.id')->join('connectors','connectors.id','=','faults.connector_id')->where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->count();
      $data['total_customers']=Users::select('id')->count();
      $get_kwh=Transactions::select(DB::raw('SUM(transactions.total_unit ) as total_unit'))->join('connectors','connectors.id','=','transactions.connector_id')->where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->first();
      $data['total_kwh']=ceil($get_kwh['total_unit']);
      $data['total_rfids']=RFIDs::where('status',1)->where('deleted_at','=',NULL)->select('id')->count();
      $data['total_wallet_balance']=UserWallets::where('status',1)->where('deleted_at','=',NULL)->sum('amount');
      $data['ac_connectors']=Connectors::where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->where('connector_type_id',1)->count();
      $data['dc_connectors']=Connectors::where('connectors.cpo_user_id',Auth::guard('admin')->user()->id)->where('connector_type_id',2)->count();


      }else{
      $data['total_charging_section']=Transactions::select('transactions.id')->join('connectors','connectors.id','=','transactions.connector_id')->count();
      $data['total_faults']=Faults::select('faults.id')->join('connectors','connectors.id','=','faults.connector_id')->count();
      $data['total_customers']=Users::select('id')->count();
      $get_kwh=Transactions::select(DB::raw('SUM(transactions.total_unit ) as total_unit'))->join('connectors','connectors.id','=','transactions.connector_id')->first();
      $data['total_kwh']=ceil($get_kwh['total_unit']);
      $data['total_rfids']=RFIDs::where('status',1)->where('deleted_at','=',NULL)->select('id')->count();
      $data['total_wallet_balance']=UserWallets::where('status',1)->where('deleted_at','=',NULL)->sum('amount');
      $data['ac_connectors']=Connectors::where('connector_type_id',1)->count();
      $data['dc_connectors']=Connectors::where('connector_type_id',2)->count();
      }


      return $data;
    }

   
}

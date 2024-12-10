<?php

namespace App\Repository\Interfaces;


interface CommonRepositoryInterface
{
    /**
     * Interface for CommonRepository.
     *
     * @author annie
     */
    public function sendOtp();
    public function otpChecking($otp);
    public function resendOtp($userId);
    public function cpoUserStatusCheck();
    public function getDashboardData();


}

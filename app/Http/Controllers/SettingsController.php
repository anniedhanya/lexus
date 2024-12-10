<?php

namespace App\Http\Controllers;

use App\Model\Settings;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\hash;
use App\Providers\RouteServiceProvider;
use App;
use Session;

class SettingsController extends Controller
{

     /**         
        *
        * @package        Laravel 8
        * @author         Annie
        * @copyright   Copyright (c) 2023, Seeroo IT Solutions (p) Ltd
        * @link       http://www.seeroo.com/
        **/

  public function no_access(){
     return view('no_access');
   }
}

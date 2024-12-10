<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Category; 
use Input,Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ExtendedWarranty;
use App\Models\Enquiry;
use App\Models\ServiceRequest;
use App\Models\Settings;
use App\Models\Model;

class HomeController extends Controller {

    
  public function index() {
    // $category = Category::where('status',1)->get()->toArray();
    // $homepage_content = Settings::all();
    // return View('index')->with(array('category' => $category, 'homecontent' => $homepage_content));
    $home_content = Settings::first();
    $models = Model::where('featured', 1)->get();   
    return view('index', compact('home_content', 'models'));
  } 

  public function detailPage() {
    return view('detail');
  }

  // public function EnquireUs() {
  //   return view('enquire_us');
  // }


    public function enquiry(Request $request){
      dd($request->all());
      $data=$request->all();
      $request->validate([
      'courtesy_title' => 'required',
      'name' => 'required|string|max:50',
      'phone' => 'required|number|max:13',
      'city' => 'required',
      'vehicle_model' => 'required',
      'job_title' => 'required',
      'company' => 'required',
      'message' => 'required',
  ], [
      'courtesy_title' => 'Please select courtesy title.',
      'name.required' => 'Please enter name.',
      'phone.required' => 'Please enter contact number.',
      'city.required' => 'Please enter city name',
      'vehicle_model.required' => 'Please enter vehicle model',
      'job_title.required' => 'Please enter job title',
      'company.required' => 'Please enter company name',
      'message.required' => 'Please enter your message',
  ]);
  
      $data = new Enquiry(); 
      $data['courtesy_title'] = $request->courtesy_title;
      $data['name'] = ucwords(strtolower($request->name));
      $data['contact_no'] = $request->phone;
      $data['city'] = $request->city;
      $data['vehicle_model'] = $request->vehicle_model;
      $data['job_title'] = $request->job_title;
      $data['company'] = $request->company;
      $data['pincode'] = $request->pincode;

      $data['message'] = $request->message;

      $data->save();
      return redirect()->back()->with('success', 'You have submitted your enquiry successfully!');
  }
}



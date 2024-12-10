<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB, Input, Excel, PDF, DateInterval, DateTime, Redirect, Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceRequest;
use App\Models\Logs;
use App\Models\Category;
use App\Models\Complaint;
use App\Exports\ExtendedWarrantyExport;
use Illuminate\Support\Facades\Session;


class ServiceRequestController extends BaseController
{
  use ResourceTrait;
  /**         
   * Date : 24/09/2024
   * @package        Laravel 10
   * @author         Rahul
   * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/
   **/

  public function __construct()
  {
    parent::__construct();
    $this->model = new ServiceRequest;
    $this->route .= '.service_request';
    $this->views .= '.service_request';

    $this->resourceConstruct();
  }

  protected function getEntityName()
  {
    return 'Service Requests';
  }
  public function index()
  {
    if (Request()->ajax()) {
      $collection = $this->getCollection();
      $route = $this->route;
      return $this->setDTData($collection)->make(true);
    } else {
      return view($this->views . '.index');
    }
  }

    public function serviceRequestList(Request $request) {
        $inputs = $request->all();
        $filter = $request->filter;

        if(isset($inputs['page_number']) && $inputs['page_number'] != "" && $inputs['page_number'] != 0) {
            $currentPage = $inputs['page_number'];
        } else {
          $currentPage = 1;
        }

        $dataArr = $this->getCollection();
        $collections = $dataArr['collection'];
        $totalCount =  $dataArr['count'];
        $totalPages = $dataArr['total_pages'];
        $offset = $dataArr['offset'];

        $resultArr = array();
        $i = 0;
        foreach ($collections as $collection) {
        $resultArr[$i]['id'] = $collection->id;
        $resultArr[$i]['name'] = ucwords(strtolower($collection->name));
        if(isset($collection->model_no)){
            $resultArr[$i]['model_no'] = $collection->model_no;
        }else{
            $resultArr[$i]['model_no'] = "-";
        }
        $resultArr[$i]['order_no'] = $collection->order_no;
        $resultArr[$i]['contact_no'] = $collection->contact_no;
        $resultArr[$i]['serial_no'] = $collection->serial_no;
        $resultArr[$i]['date_of_purchase'] = Carbon::parse($collection->date_of_purchase)->format('d F Y');
        $resultArr[$i]['created_on'] = Carbon::parse($collection->created_at)->format('d F Y');
        $get_cat=Category::where('id',$collection->product_id)->first();
        $resultArr[$i]['category'] = $get_cat['category'];
        if(isset($collection->complaint_id)) {
          $get_cmp = Complaint::where('id', $collection->complaint_id)->first();
          $resultArr[$i]['complaint'] = $get_cmp['complaint'];
        } else {
          $resultArr[$i]['complaint'] = "-";
        }

        if($collection->status==1){
        $resultArr[$i]['status'] = 'Open';
        }else{
        $resultArr[$i]['status'] = 'Closed';
        }

        if(isset($collection->executive_user)) {
            $resultArr[$i]['executive'] = $collection->executive_user;
        }else{
            $resultArr[$i]['executive'] = '-';
        }


        if(isset($collection->remarks)) {
            $resultArr[$i]['remarks'] = Str::limit($collection->remarks, 10, '...');
        } else {
            $resultArr[$i]['remarks'] = "-";
        }

        if(isset($collection->gst_no)) {
            $resultArr[$i]['gst_no'] = $collection->gst_no;
        }
        else {
            $resultArr[$i]['gst_no'] = '-';
        }



        $i++;
        }
        $data['status'] = true;
        $data['result'] = $resultArr;
        $data['count'] = $i;
        $data['total_count'] = $totalCount;
        $data['current_page'] = $currentPage;
        $data['total_pages'] = $totalPages;
        $data['offset'] = $offset;
        $data['user_type'] = Auth::guard('admin')->user()->type;
        return response()->json($data, 200);
    }
    protected function getCollection()
  {
    $data = Input::all();
    $filter = $data['filter'];
    DB::enableQueryLog();
    $user=Auth::guard('admin')->user();
    
    $collection = $this->model->select('*');

    if (isset($filter['name'])) {
      if ($filter['name'] != '') {
         $collection = $collection->where('name',$filter['name']);
       }
     }

    if (isset($filter['contact_number'])) {
      if ($filter['contact_number'] != '') {
         $collection = $collection->where('contact_no',$filter['contact_number']);
       }
     }

    if (isset($filter['search_order_id'])) {
      if ($filter['search_order_id'] != '') {
         $collection = $collection->where('order_no',$filter['search_order_id']);
       }
     }

    if (isset($filter['category_id'])) {
      if ($filter['category_id'] != '') {
         $collection = $collection->where('product_category_id',$filter['category_id']);
       }
     }

     if (isset($filter['search_executive_user_id'])) {
      if ($filter['search_executive_user_id'] != '') {
         $collection = $collection->where('executive_user_id',$filter['search_executive_user_id']);
       }
     }

    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('service_request.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('service_request.order_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('service_request.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('service_request.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }

     if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('service_request.name', 'like', '%' . $searchString . '%')
          ->orwhere('service_request.order_no', 'like', '%' . $searchString . '%')
            ->orWhere('service_request.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('service_request.contact_no', 'like', '%' . $searchString . '%');
        });
      }
    }

    if (isset($filter['from_date']) && isset($filter['to_date'])) {
      $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
      $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
      if($filter['from_date']== $filter['to_date']){
        $collection = $collection->where('created_at',  'like', '%' . $filter['from_date'] . '%');
      }else{
        $collection = $collection->whereBetween('created_at', [$filter['from_date'], $filter['to_date']]);
      }
  } elseif (isset($filter['from_date'])) {
      $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
      $collection = $collection->where('created_at',  'like', '%' . $filter['from_date'] . '%');
  } elseif (isset($filter['to_date'])) {
      $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
      $collection = $collection->where('created_at', 'like', '%' . $filter['to_date'] . '%');
  }
  

    $count = $collection->count();


    if ($count > 0) {
        if (isset($data['page_number']) && $data['page_number'] != "" && $data['page_number'] != 0) {
            $currentPage = $data['page_number'];
        } else {
            $currentPage = 1;
        }

        if (isset($filter['per_page_count'])) {
            $perpage = $filter['per_page_count'];
        } else {
            $perpage = 10;
        }

        $pages = ceil($count / $perpage);
        $pages = (int) $pages;
        $offset = (($currentPage - 1) * $perpage);
        DB::enableQueryLog();

        $collection = $this->model->select('*');

        if (isset($filter['name'])) {
            if ($filter['name'] != '') {
                $collection = $collection->where('name',$filter['name']);
            }
        }


    if (isset($filter['contact_number'])) {
      if ($filter['contact_number'] != '') {
         $collection = $collection->where('contact_no',$filter['contact_number']);
       }
     }


    if (isset($filter['search_order_id'])) {
      if ($filter['search_order_id'] != '') {
         $collection = $collection->where('order_no',$filter['search_order_id']);
       }
     }


    if (isset($filter['category_id'])) {
      if ($filter['category_id'] != '') {
         $collection = $collection->where('product_category',$filter['category_id']);
       }
     }

     if (isset($filter['search_executive_user_id'])) {
      if ($filter['search_executive_user_id'] != '') {
         $collection = $collection->where('executive_user_id',$filter['search_executive_user_id']);
       }
     }
 
    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('service_request.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('service_request.order_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('service_request.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('service_request.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }
        if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('service_request.name', 'like', '%' . $searchString . '%')
          ->orwhere('service_request.order_no', 'like', '%' . $searchString . '%')
            ->orWhere('service_request.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('service_request.contact_no', 'like', '%' . $searchString . '%');
        });
      }
    }


    if (isset($filter['from_date']) && isset($filter['to_date'])) {
      $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
      $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
      if($filter['from_date']== $filter['to_date']){
        $collection = $collection->where('created_at',  'like', '%' . $filter['from_date'] . '%');
      }else{
        $collection = $collection->whereBetween('created_at', [$filter['from_date'], $filter['to_date']]);
      }
    } elseif (isset($filter['from_date'])) {
      $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
      $collection = $collection->where('created_at',  'like', '%' . $filter['from_date'] . '%');
    } elseif (isset($filter['to_date'])) {
        $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
        $collection = $collection->where('created_at', 'like', '%' . $filter['to_date'] . '%');
    }
  
  

      $collection = $collection->orderby('id', 'DESC')
        ->skip($offset)
        ->take($perpage)
        ->get();
    } else {
      $pages = 0;
      $offset = 0;
    }
    $dataArr['collection'] = $collection;
    $dataArr['count'] = $count;
    $dataArr['offset'] = $offset;
    $dataArr['total_pages'] = $pages;
    return $dataArr;
  }



  

  protected function setDTData($collection, $qs_array = [])
  {
    $route = $this->route;
    $filter = Input::get('filter');
    return $this->initDTData($collection)

      ->editColumn('created_at', function ($obj) {
        return $obj->created_at ? $obj->created_at->format('d/m/Y h:i a') : 'Unknown';
      })
      ->editColumn('status', '@if($status) Active @else Inactive @endif');
  }

  protected function prepareData($update = NULL)
  {
    $data = Input::all();
    return $data;
  }

  public function store(Request $request)
  {
    $data = Input::all();
    $validator = Validator::make(
      $data,
      [

    'name' => 'required|string|max:255',
    'contact_no' => 'required|max:15',
    'order_id' => 'required',
    'category_id' => 'required',
    'model_no' => 'nullable|min:15|max:20',
    'address' => 'required',
    'date_of_purchase' => 'required',
    'serial_no' => 'required',
    'remarks' => 'required',
    'video_upload' => 'nullable|file|mimes:mkv,mp4,mov,avi|max:102400'
      ],
      [
    'name.required' => 'Please enter name.',
    'contact_no.required' => 'Please enter contact number.',
    'date_of_purchase.required' => 'Please select date of purchase',
    'serial_no.required' => 'Please enter serial number',
    'category_id.required' => 'Select product category',
    'model_no.min' => 'Model number must be at least 15 characters.',
    'model_no.max' => 'Model number must not exceed 20 characters.',
    'address.required' => 'Please enter address',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors($validator->errors());
    }
    return $this->_store($request);
  }

  public function _store($request)
  {
    $data = Input::all();
    
    if ($request->hasFile('video_upload')) {
        $video_ = $request->file('video_upload');
        $extension = $video_->getClientOriginalExtension();
        $videoName = $request->category_id.'-'.$request->order_id.'-'.$video_->getClientOriginalName();
        $video_path_ = 'uploads/video_upload/'.$videoName; 
        $video_->move(public_path('uploads/video_upload/'), $videoName);
        $videopath =$video_path_;
      }

    $this->model->fill($this->prepareData());
    DB::beginTransaction();
    try {
        $save_data = new ServiceRequest(); 
        $save_data['name'] = $request->name;
        $save_data['contact_no'] = $request->contact_no;
        if(isset($request->remarks)) {
        	$save_data['remarks'] = $request->remarks;
        }
        $save_data['product_id'] = $request->category_id;
        if(isset($request->model_no)){
          $save_data['model_no'] = $request->model_no; 
        }
        $save_data['order_no'] = $request->order_id;
        $save_data['serial_no'] = $request->serial_no;
        if(isset($request->status)) {
            $save_data['status'] = $request->status;
        }
        $save_data['date_of_purchase'] = \Carbon\Carbon::parse($request->date_of_purchase)->format('Y-m-d');
        $save_data['video_file'] = $videopath ?? null;
        $save_data['video_extension'] = $extension ?? null;
        $save_data['address'] = $request->address;
        $save_data['executive_user'] = Auth::guard('admin')->user()->name;
        $save_data->save();

      DB::commit();
      $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Service Request',
                             'action'=> 'Service Request Added for '.$request->contact_no.' by '.Auth::guard('admin')->user()->name
                            ); 
            Logs::insertLog($log_arr);
      return $this->redirect('created successfully.');
      
    } catch (Exception $e) {

      DB::rollBack();
      return $this->redirect('Not Created');
    }
  }
 

  public function edit($id)
  {

    $obj = $this->model->where('id', $id)->first();

    if ($obj) {
      return view($this->views . '.form')->with(array('obj' => $obj));
    } else {
      return $this->redirect('notfound', 'error');
    }
  }

  public function update($id, Request $request)
  {
    $data = Input::all();

    $validator = Validator::make(Input::all(), [
      'name' => 'required|string|max:50',
      'contact_no' => 'required|max:15',
      'address' => 'required',
      'order_id' => 'required|min:4|max:20',
      'category_id' => 'required',
      'model_no' => 'nullable|max:20|min:15',
      'serial_no' => 'required',
      'spare_name' => 'required',
      'date_of_purchase' => 'required',
      'spare_order_date' => 'required',
      'spare_dispatch_date' => 'required',
      'executive_user_id' => 'required',
      'courier' => 'required',
      'complaint' => 'required',
      'remarks' => 'required',
      'status' => 'required',
      'video_upload' => 'nullable|file|mimes:mkv,mp4,mov,avi|max:102400'
  ], [
      'name.required' => 'Name field is required.',
      'contact_no.required' => 'Contact number field is required.',
      'address.required' => 'Adddress field is required',
      'order_id.required' => 'Please enter order number',
      'order_id.min' => 'Order number must be at least 15 characters.',
      'order_id.max' => 'Order number must not exceed 20 characters.',
      'model_no.min' => 'Model number must be at least 15 characters.',
      'model_no.max' => 'Model number must not exceed 20 characters.',
      'serial_no.required' => 'Please enter serial number',
      'spare_name.required' => 'please enter spare name',
      'date_of_purchase.required' => 'Please provide date of purchase',
      'spare_order_date.required' => 'Please provide order date of spare',
      'spare_dispatch_date.required' => 'Please provide dispatch date of the order',
      'courier.required' => 'Please enter courier',
      'complaint.required' => 'Please enter complaint',
      'remarks.required' => 'Please enter remarks',
      'status.required' => 'Please select status',
      'category_id.required' => 'Product Category field is required.',
      'executive_user_id.required' => 'Executive field is required',
  ]);
  
        
    if ($validator->fails()) {
      $current_url = url('extended_warranty', ['extended_warranty' => $id], 'edit');
      return Redirect::back()->withInput()->withErrors($validator);
    }
 
    return $this->_update($id, $request);
  }

  protected function _update($id, $request)
  {
    $obj = $this->model->find($id);

    if ($obj) {
      if ($request->hasFile('video_upload')) {
        $video_ = $request->file('video_upload');
        $extension = $video_->getClientOriginalExtension();
        $videoName = $request->category_id.'-'.$request->order_id.'-'.$video_->getClientOriginalName();
        $video_path_ = 'uploads/video_upload/'.$videoName; 
        $video_->move(public_path('uploads/video_upload/'), $videoName);
        $videopath =$video_path_;
      }

      $data = Input::all();
      if(isset($data['model_no'])){
       $model_no=$data['model_no'];
      }else{
       $model_no="";
      }

      if(isset($data['gst_no'])) {
        $gst = $data['gst_no'];
      }else {
        $gst = '';
      }

      $user = Auth::guard('admin')->user();
      if($user->type == 1) {
        $executive_user_id = $user->name;
      }
      else {
        $executive_user_id = $data['executive_user_id'];
      }
      if(isset($data['date_of_purchase'])){
        $date_of_purchase= \Carbon\Carbon::parse($data['date_of_purchase'])->format('Y-m-d');
      }else{
        $date_of_purchase=NULL;
      }
      if(isset($data['spare_order_date'])){
        $spare_order_date= \Carbon\Carbon::parse($data['spare_order_date'])->format('Y-m-d');
      }else{
        $spare_order_date=NULL;
      }
      if(isset($data['spare_dispatch_date'])){
        $spare_dispatch_date= \Carbon\Carbon::parse($data['spare_dispatch_date'])->format('Y-m-d');
      }else{
        $spare_dispatch_date=NULL;
      }
        $this->update_data('ServiceRequest', array('id' => $id), array(
          'model_no' => $model_no,
          'name' => ucwords(strtolower($data['name'])),
          'contact_no' => $data['contact_no'],
          'order_no' => $data['order_id'],
          'product_id' => $data['category_id'],
          'serial_no' => $data['serial_no'],
          'date_of_purchase' => $date_of_purchase,
          'executive_user' => $executive_user_id,
          'spare_name' => $data['spare_name'],
          'spare_order_date' => $spare_order_date,
          'spare_dispatch_date' => $spare_dispatch_date,
          'courier' => $data['courier'],
          'complaint_id' => $data['complaint'],
          'status' => $data['status'],
          'address' => $data['address'],
          'remarks' => $data['remarks'],
          'video_file' => $videopath ?? null,
          'video_extension' => $extension ?? null
        ));
  
   $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Trade Enquiry',
                             'action'=> Auth::guard('admin')->user()->name." Trade Enquiry Updated"
                            ); 
            Logs::insertLog($log_arr);
      
      return $this->redirect('Updated Successfully.');
    } else {
      return $this->redirect('notfound.', 'error');
    }
  }

  public function serviceRequestDelete(Request $request)
  {

    $flag = 0;
    $obj = $this->model->find($request->id);
    if ($obj) {

      ServiceRequest::where('id', $request->id)->delete();

      return $this->redirect('Deleted Successfully.');
    } else
      $flag = 1;

    if ($flag == 1)
      return $this->redirect('notfound', 'error');
  }
}

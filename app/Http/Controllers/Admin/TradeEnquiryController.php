<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB, Input, Excel, PDF, DateInterval, DateTime, Redirect, Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Enquiry;
use App\Models\Logs;
use App\Models\Category;
use App\Exports\ExtendedWarrantyExport;
use Illuminate\Support\Facades\Session;


class TradeEnquiryController extends BaseController
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
    $this->model = new Enquiry;
    $this->route .= '.enquiries';
    $this->views .= '.enquiries';

    $this->resourceConstruct();
  }

  protected function getEntityName()
  {
    return 'Enquiry';
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

  public function enquiryList(Request $request)
  {
    $inputs = $request->all();
    $filter = $request->filter;

    if (isset($inputs['page_number']) && $inputs['page_number'] != "" && $inputs['page_number'] != 0) {
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
      $resultArr[$i]['email'] = $collection->email;
      $resultArr[$i]['name'] = ucwords(strtolower($collection->name));
      $resultArr[$i]['contact_no'] = $collection->contact_no;
      $resultArr[$i]['created_on'] = Carbon::parse($collection->created_at)->format('d F Y');
      $resultArr[$i]['district'] = $collection->district;
      $resultArr[$i]['pincode'] = $collection->pincode;



      if(isset($collection->message)) {
        $resultArr[$i]['message'] = Str::limit($collection->message, 10, '...');
      } else {
        $resultArr[$i]['message'] = "-";
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

    if (isset($filter['modal_number'])) {
      if ($filter['modal_number'] != '') {
         $collection = $collection->where('modal_no',$filter['modal_number']);
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
          $query->where('trade_enquiry.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('trade_enquiry.gst_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('trade_enquiry.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('trade_enquiry.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }

     if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('trade_enquiry.name', 'like', '%' . $searchString . '%')
          ->orwhere('trade_enquiry.gst_no', 'like', '%' . $searchString . '%')
            ->orWhere('trade_enquiry.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('trade_enquiry.contact_no', 'like', '%' . $searchString . '%');
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


    if (isset($filter['modal_number'])) {
      if ($filter['modal_number'] != '') {
         $collection = $collection->where('modal_no',$filter['modal_number']);
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
          $query->where('trade_enquiry.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('trade_enquiry.gst_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('trade_enquiry.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('trade_enquiry.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }
        if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('trade_enquiry.name', 'like', '%' . $searchString . '%')
          ->orwhere('trade_enquiry.gst_no', 'like', '%' . $searchString . '%')
            ->orWhere('trade_enquiry.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('trade_enquiry.contact_no', 'like', '%' . $searchString . '%');
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
    'email' => 'required|email|max:255',
    'district' => 'required',
    'pincode' => 'required',
    'description' => 'required'
  ],
      [
    'name.required' => 'Please enter name.',
    'contact_no.required' => 'Please enter contact number.',
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
    

    $this->model->fill($this->prepareData());
    DB::beginTransaction();
    try {
        $save_data = new TradeEnquiry(); 
        $save_data['name'] = $request->name;
        $save_data['contact_no'] = $request->contact_no;
        if(isset($request->description)) {
        	$save_data['message'] = $request->description;
        }
        $save_data['product_category'] = $request->category_id;
        if(isset($request->model_name)){
          $save_data['model_name'] = $request->model_name; 
        }
        if(isset($request->status)) {
            $save_data['status'] = $request->status;
        }
        $save_data['address'] = $request->address;
        $save_data['executive_user'] = Auth::guard('admin')->user()->name;
        $save_data->save();

      DB::commit();
      $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Enquiry',
                             'action'=> 'Enquiry Added for '.$request->contact_no.' by '.Auth::guard('admin')->user()->name
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
      'category_id' => 'required',
      'model_no' => 'nullable|max:20|min:15',
      'executive_user_id' => 'required',
      'remarks' => 'required',
      'status' => 'required',
  ], [
      'name.required' => 'Name field is required.',
      'contact_no.required' => 'Contact number field is required.',
      'model_no.min' => 'Model number must be at least 15 characters.',
      'model_no.max' => 'Model number must not exceed 20 characters.',
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
        $this->update_data('TradeEnquiry', array('id' => $id), array(
          'model_no' => $model_no,
          'name' => ucwords(strtolower($data['name'])),
          'gst_no' => $gst,
          'contact_no' => $data['contact_no'],
          'product_category' => $data['category_id'],
          'executive_user' => $executive_user_id,
          'quantity' => $data['quantity'],
          'status' => $data['status'],
          'address' => $data['address'],
          'remarks' => $data['remarks']
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

  public function tradeEnquiryDelete(Request $request)
  {

    $flag = 0;
    $obj = $this->model->find($request->id);
    if ($obj) {

      TradeEnquiry::where('id', $request->id)->delete();

      return $this->redirect('Deleted Successfully.');
    } else
      $flag = 1;

    if ($flag == 1)
      return $this->redirect('notfound', 'error');
  }

 
 public function extendedWarrantyPdf(Request $request)
  {
    $collection = ExtendedWarranty::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.name as name','extended_warranty.order_id as order_id','category.category as category','extended_warranty.model_no as model_no','extended_warranty.date_of_purchase as date_of_purchase','extended_warranty.warranty_period as warranty_period','extended_warranty.warranty_period_from as warranty_period_from','extended_warranty.warranty_period_to as warranty_period_to')
    ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
    ->where('extended_warranty.id',$request->warranty_user_id)
    ->orderby('extended_warranty.id', 'ASC');
    $collections = $collection->first();

 
      $resultArr['name'] = ucwords(strtolower($collections->name));
      $resultArr['model_no'] = $collections->model_no;
      $resultArr['order_id'] = $collections->order_id;
      if(isset($collections->date_of_purchase)){
        $resultArr['date_of_purchase'] =  \Carbon\Carbon::parse($collections->date_of_purchase)->format('d F Y');
      }else{
        $resultArr['date_of_purchase'] = "-";
      }
      
      $resultArr['category'] = $collections->category;
      if(isset($collections->warranty_period)){
      $resultArr['warranty_period'] = \Carbon\Carbon::parse($collections->warranty_period)->format('d F Y');
      }else{
      $resultArr['warranty_period'] = "-";
      }

      if(isset($collections->warranty_period_from)){
        $resultArr['warranty_period_from'] = \Carbon\Carbon::parse($collections->warranty_period_from)->format('d F Y');
      }else{
        $resultArr['warranty_period_from'] ="-";
      }


   if(isset($collections->warranty_period_to)){
        $resultArr['warranty_period_to'] = \Carbon\Carbon::parse($collections->warranty_period_to)->format('d F Y');
      }else{
        $resultArr['warranty_period_to'] ="-";
      }

    $pdf =  PDF::loadView('Admin.extended_warranty.pdf', array('collection' => $resultArr));
    $destinationPath = public_path('uploads/extended_warranty');
    $pdfName = ucwords(strtolower($collections->name)) .'-'.$collections->order_id.'-'. $resultArr['date_of_purchase'] . '.' . 'pdf';
    $pdf->save($destinationPath . '/' . $pdfName);
    //return $pdf->download('extended_warranty_list.pdf');
    return response()->download($destinationPath . '/' . $pdfName, $pdfName);  }


  public function extendedWarrantyExport(Request $request)
  { 
    ob_end_clean();
    ob_start();
    // return Excel::download(new ExtendedWarrantyExport($request->name, $request->contact_number, $request->modal_number, $request->category_id), 'Extended_Warranty_List.xlsx');
    return Excel::download(new ExtendedWarrantyExport($request->contact_number, $request->warranty_period_from, $request->warranty_period_to,$request->search,$request->search_executive_user_id,$request->search_assigned_user_id,$request->search_warranty_status,$request->search_screenshot_status,$request->search_order_id), 'Extended_Warranty_List.xlsx');

  }

  public function checkOrderId(Request $request) {
    $order_id = $request->input('order_id');

    $exists = true;

    $exists = TradeEnquiry::where('order_id', $order_id)->exists();

    return response()->json(['unique' => $exists]);
  }

  public function removeFile(Request $request)
{
    $fileType = $request->input('file_type');
    $fileId = $request->input('file_id');

    $obj = TradeEnquiry::find($fileId);
    
    if($obj) {
        $filePath = '';

        if($fileType == 'doc_screenshot') {
            $filePath = public_path($obj->doc_screenshot_file);
            $obj->doc_screenshot_file = null;
            $obj->doc_screenshot_extension = null;
        } elseif($fileType == 'invoice_link') {
            $filePath = public_path($obj->invoice_link);
            $obj->invoice_link = null;
            $obj->invoice_link_extension = null;
        }

        if(file_exists($filePath)) {
            unlink($filePath);
        }

        $obj->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}


}

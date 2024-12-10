<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB, Input, Excel, PDF, DateInterval, DateTime, Redirect, Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\ExtendedWarranty;
use App\Models\UserAssignedList;
use App\Models\Logs;
use App\Models\Category;
use App\Exports\ExtendedWarrantyExport;

class AssignUserController extends BaseController
{
  use ResourceTrait;
  /**         
   * Date : 1/07/2024
   * @package        Laravel 10
   * @author         Annie
   * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/
   **/

  public function __construct()
  {
    parent::__construct();
    $this->model = new UserAssignedList;
    $this->route .= '.assign_users';
    $this->views .= '.assign_users';

    $this->resourceConstruct();
    $this->middleware('checkRole:assign_users');
  }

  protected function getEntityName()
  {
    return 'Assign Users';
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

  public function extendedWarrantyList(Request $request)
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
      $resultArr[$i]['name'] = ucwords(strtolower($collection->name));
      if(isset($collection->model_no)){
        $resultArr[$i]['model_no'] = $collection->model_no;
      }else{
        $resultArr[$i]['model_no'] = "-";
      }
      
      $resultArr[$i]['contact_no'] = $collection->contact_no;
      $resultArr[$i]['order_id'] = $collection->order_id;
      $get_cat=Category::where('id',$collection->product_category_id)->first();
      $resultArr[$i]['category'] = $get_cat['category'];
      if(isset($collection->warranty_period)){
      $resultArr[$i]['warranty_period'] = $collection->warranty_period;
      }else{
      $resultArr[$i]['warranty_period'] = "";
      }

      if(isset($collection->warranty_status)){
      $resultArr[$i]['warranty_status'] = $collection->warranty_status;
      }else{
      $resultArr[$i]['warranty_status'] = "";
      }
      if($collection->status==1){
      $resultArr[$i]['status'] = 'Active';
      }else{
      $resultArr[$i]['status'] = 'Inactive';
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
    return response()->json($data, 200);
  }


  protected function getCollection()
  {
    $data = Input::all();
    $filter = $data['filter'];
    DB::enableQueryLog();
    $collection = $this->model->where('status', 1);

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



    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }

     if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString . '%');
        });
      }
    }

    if (isset($filter['from_date']) && isset($filter['to_date'])) {
    $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
    $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
    $collection = $collection->where(function($query) use ($filter) {
        $query->whereBetween('extended_warranty_from', [$filter['from_date'], $filter['to_date']])
              ->orWhereBetween('extended_warranty_to', [$filter['from_date'], $filter['to_date']]);
    });
} elseif (isset($filter['from_date'])) {
    $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
    $collection = $collection->where('extended_warranty_from', '>=', $filter['from_date']);
} elseif (isset($filter['to_date'])) {
    $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
    $collection = $collection->where('extended_warranty_to', '<=', $filter['to_date']);
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
      $collection = $this->model->where('status', 1);

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



if (isset($filter['from_date']) && isset($filter['to_date'])) {
    $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
    $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
    $collection = $collection->where(function($query) use ($filter) {
        $query->whereBetween('extended_warranty_from', [$filter['from_date'], $filter['to_date']])
              ->orWhereBetween('extended_warranty_to', [$filter['from_date'], $filter['to_date']]);
    });
} elseif (isset($filter['from_date'])) {
    $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
    $collection = $collection->where('extended_warranty_from', '>=', $filter['from_date']);
} elseif (isset($filter['to_date'])) {
    $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
    $collection = $collection->where('extended_warranty_to', '<=', $filter['to_date']);
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
 
    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }
        if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString . '%');
        });
      }
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

  public function store()
  {
    $data = Input::all();
    $validator = Validator::make(
      $data,
      [

    'assigned_id' => 'required',
    'registration_id_from' => 'required',
     'registration_id_to' => 'required',
   
    

      ],
      [
    'assigned_id.required' => 'Please enter a user.',
    'registration_id_from.required' => 'Please select list from.',
    'registration_id_to.required' => 'Please select list to.',
   
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors($validator->errors());
    }
    return $this->_store();
  }

  public function _store()
  {
    $data = Input::all();

    $this->model->fill($this->prepareData());
    DB::beginTransaction();
    try {
         $registration_id_from = $data['registration_id_from'];
         $registration_id_to = $data['registration_id_to'];
         $ids = range($registration_id_from, $registration_id_to);

         foreach ($ids as $id) {
         $warranty = ExtendedWarranty::where('warranty_status','=',NULL)->find($id);
         if ($warranty) {
             ExtendedWarranty::where('id',$id)->update(['assigned_user_id'=>$data['assigned_id']]);
             $assign_save = new UserAssignedList; 
             $assign_save['user_id'] = $data['assigned_id'];
             $assign_save['extended_warranty_id'] = $id;
             $assign_save->save();
            
           
        }
    }
     
      DB::commit();
          return redirect('admin/assign_users/create')->with('success', 'Created successfully.');
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

  public function update($id)
  {
    $data = Input::all();

    $validator = Validator::make(Input::all(), [
      'name' => 'required|string|max:50',
      'email' => 'nullable|email',
      'contact_no' => 'required|max:15',
      'order_id' => 'required|max:20|min:4',
      'category_id' => 'required',
      'model_no' => 'nullable|max:10|min:4',
      'executive_user_id' => 'required',
      'assigned_user_id' => 'required',
      // 'warranty_period' => 'required_if:warranty_status,1',
      'date_of_purchase' => 'required_if:warranty_status,1',
      'warranty_period_from' => 'required_if:warranty_status,1',
      'warranty_period_to' => 'required_if:warranty_status,1',
      'screenshot_status' => 'required',
      'warranty_status' => 'required',
      'remarks' => 'required'
  ], [
      'name.required' => 'Name field is required.',
      'email.email' => 'The email field must be a valid email address.',
      'contact_no.required' => 'Contact number field is required.',
      'order_id.required' => 'Order ID field is required.',
      // 'model_no.required' => 'Model No field is required.',
      'order_id.min' => 'Order ID must be at least 4 characters.',
      'order_id.max' => 'Order ID must not exceed 20 characters.',
      'model_no.min' => 'Model number must be at least 4 characters.',
      'model_no.max' => 'Model number must not exceed 10 characters.',
      'category_id.required' => 'Product Category field is required.',
      'executive_user_id.required' => 'Executive field is required',
      'assigned_user_id.required' => 'Assigned to field is required',
      // 'warranty_period.required_if' => 'Extended warranty period field is required when warranty status is issued',
      'date_of_purchase.required_if' => 'Date of purchase field is required when warranty status is issued',
      'screenshot_status.required' => 'Screenshot status field is required',
      'warranty_status.required' => 'Warranty status field is required',
      'remarks.required' => 'Remarks field is required',
      'warranty_period_from.required_if' => 'Extended warranty period from field is required when warranty status is issued',
      'warranty_period_to.required_if' => 'Extended warranty period to field is required when warranty status is issued'

  ]);
  
        
    if ($validator->fails()) {
      $current_url = url('extended_warranty', ['extended_warranty' => $id], 'edit');
      return Redirect::back()->withInput()->withErrors($validator);
    }
 
    return $this->_update($id);
  }

  protected function _update($id)
  {
    if ($obj = $this->model->find($id)) {
      $data = Input::all();
      if(isset($data['warranty_period_from'])){
        $warranty_period_from= \Carbon\Carbon::parse($data['warranty_period_from'])->format('Y-m-d');
      }else{
        $warranty_period_from=NULL;
      }


   if(isset($data['warranty_period_to'])){
        $warranty_period_to= \Carbon\Carbon::parse($data['warranty_period_to'])->format('Y-m-d');
      }else{
        $warranty_period_to=NULL;
      }


      if(isset($data['date_of_purchase'])){
        $date_of_purchase= \Carbon\Carbon::parse($data['date_of_purchase'])->format('Y-m-d');
      }else{
        $date_of_purchase=NULL;
      }
      if(isset($data['model_no'])){
       $model_no=$data['model_no'];
      }else{
       $model_no="";
      }

     $user_type=Auth::guard('admin')->user();
     if($user_type->type==1){
      $executive_user_id=$user_type->id;

     }else{
$executive_user_id=$data['executive_user_id'];
     }


      $this->update_data('ExtendedWarranty', array('id' => $id), array(
              'model_no' => $model_no,
              'order_id' => $data['order_id'],
              'name' => ucwords(strtolower($data['name'])),
              'contact_no' => $data['contact_no'],
              'email' => $data['email'],
              'product_category_id' => $data['category_id'],
              'executive_user_id' => $executive_user_id,
              'assigned_user_id' => $data['assigned_user_id'],
              'warranty_period_from' => $warranty_period_from,
              'warranty_period_to' => $warranty_period_to,
              'date_of_purchase' => $date_of_purchase,
              'screenshot_status' => $data['screenshot_status'],
              'warranty_status' => $data['warranty_status'],
              'remarks' => $data['remarks']
            ));

   $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Extended Warranty',
                             'action'=> $data['name'].' Extended Warranty Updated'
                            ); 
            Logs::insertLog($log_arr);
      
      return $this->redirect('Updated Successfully.');
    } else {
      return $this->redirect('notfound.', 'error');
    }
  }

  public function extendedWarrantyDelete(Request $request)
  {

    $flag = 0;
    $obj = $this->model->find($request->id);
    if ($obj) {
      if(isset($obj['doc_screenshot_file'])){
        unlink($obj['doc_screenshot_file']);
      }
      if(isset($obj['invoice_link'])){
        unlink($obj['invoice_link']);
      }
      ExtendedWarranty::where('id', $request->id)->delete();
     
      return $this->redirect('Deleted Successfully.');
    } else
      $flag = 1;

    if ($flag == 1)
      return $this->redirect('notfound', 'error');
  }

 
 public function extendedWarrantyPdf(Request $request)
  {
    $collection = ExtendedWarranty::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.name as name','extended_warranty.order_id as order_id','category.category as category','extended_warranty.model_no as model_no','extended_warranty.date_of_purchase as date_of_purchase','extended_warranty.warranty_period as warranty_period')
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
    return Excel::download(new ExtendedWarrantyExport($request->name, $request->contact_number, $request->modal_number, $request->category_id,$request->warranty_period_from,$request->warranty_period_to), 'Extended_Warranty_List.xlsx');
  }


}

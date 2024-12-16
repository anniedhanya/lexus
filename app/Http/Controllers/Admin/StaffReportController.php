<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB, Input, Excel, PDF, DateInterval, DateTime, Redirect, Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\ExtendedWarranty;
use App\Models\Logs;
use App\Models\Category;
use App\Exports\ExtendedWarrantyExport;
use App\Exports\StaffReportExport;
use Illuminate\Support\Facades\Session;
use App\Models\UserAssignedList;

class StaffReportController extends BaseController
{
  use ResourceTrait;
  /**         
   * Date : 1/07/2024
   * @package        Laravel 10
   * @author         Rahul
   * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/
   **/

  public function __construct()
  {
    parent::__construct();
    $this->model = new UserAssignedList;
    $this->route .= '.staff_report';
    $this->views .= '.staff_report';

    $this->resourceConstruct();
    $this->middleware('checkRole:staff_report');
  }

  protected function getEntityName()
  {
    return 'Staff Report';
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
      $resultArr[$i]['created_on'] = Carbon::parse($collection->created_at)->format('d F Y');
      $resultArr[$i]['assigned_date'] = Carbon::parse($collection->assigned_date)->format('d F Y');
      if(isset($collection->created_by)) {
        $resultArr[$i]['created_by'] = $collection->created_by;
      }
      else {
        $resultArr[$i]['created_by'] = '-';
      }
      $get_cat=Category::where('id',$collection->product_category_id)->first();
      $resultArr[$i]['category'] = $get_cat['category'];


      // if(isset($collection->warranty_period)){
      // $resultArr[$i]['warranty_period'] = $collection->warranty_period;
      // }else{
      // $resultArr[$i]['warranty_period'] = "";
      // }

      if(isset($collection->warranty_period_from) || isset($collection->warranty_period)){
        if(isset($collection->warranty_period_from)){
          $resultArr[$i]['warranty_period'] = $collection->warranty_period_from;
        }else{
          $resultArr[$i]['warranty_period'] = $collection->warranty_period;
        }
        }else{
        $resultArr[$i]['warranty_period'] = "";
        }

      // if(isset($collection->warranty_status)){
      // $resultArr[$i]['warranty_status'] = $collection->warranty_status;
      // }else{
      // $resultArr[$i]['warranty_status'] = "";
      // }
      if($collection->status==1){
      $resultArr[$i]['status'] = 'Active';
      }else{
      $resultArr[$i]['status'] = 'Inactive';
      }


      if(isset($collection->warranty_status)){
        if($collection->warranty_status == 1) {
          $resultArr[$i]['warranty_status'] = 'Issued';
        }
        else if($collection->warranty_status == 2) {
          $resultArr[$i]['warranty_status'] = 'Pending';
        }else{
          $resultArr[$i]['warranty_status'] = 'Denied';
        }
      }else{
        $resultArr[$i]['warranty_status'] = "-";
      }

      // if(isset($collection->executive_user_id)) {
      //   // $executive = User::where('id',  $collection->executive_user_id)->first();
      //   $resultArr[$i]['executive'] = $collection->executive_user_id;
      // }
      // else {
      //   if(isset($collection->created_by)) {
      //     $resultArr[$i]['executive'] = $collection->created_by;
      //   }else{
      //     $resultArr[$i]['executive'] = 'Customer';
      //   }
        
      // }

      if(isset($collection->executive_user_id)) {
         $resultArr[$i]['executive'] = $collection->executive_user_id;
      } else {
        $resultArr[$i]['executive'] = '-';
      }

      if(isset($collection->assigned_user_id)) {
        $assignee = User::where('id',  $collection->assigned_user_id)->first();
        $resultArr[$i]['assignee'] = $assignee->name;
      }
      else {
        $resultArr[$i]['assignee'] = '-';
      }

      if (isset($collection->star_rating)) {
        switch ($collection->star_rating) {
            
            case 1:
                $resultArr[$i]['star_rating'] = '1 Star';
                break;
            case 2:
                $resultArr[$i]['star_rating'] = '2 Star';
                break;
            case 3:
                $resultArr[$i]['star_rating'] = '3 Star';
                break;
            case 4:
                $resultArr[$i]['star_rating'] = '4 Star';
                break;
            case 5:
                $resultArr[$i]['star_rating'] = '5 Star';
                break;
            default:
                $resultArr[$i]['star_rating'] = '-';
                break;
        }
    } else {
        $resultArr[$i]['star_rating'] = '-';
    }

      if(isset($collection->live_status)) {
        if($collection->live_status == 1) {
          $resultArr[$i]['live_status'] = 'Yes';
        }
        elseif($collection->live_status == 0) {
          $resultArr[$i]['live_status'] = 'No';
        }
      }
      else {
        $resultArr[$i]['live_status'] = '-';
      }

      if(isset($collection->screenshot_status)) {
        if($collection->screenshot_status == 1) {
          $resultArr[$i]['screenshot_status'] = 'Yes';
        }
        elseif($collection->screenshot_status == 0) {
          $resultArr[$i]['screenshot_status'] = 'No';
        }
      }
      else {
        $resultArr[$i]['screenshot_status'] = '-';
      }

      if(isset($collection->remarks)) {
        $resultArr[$i]['remarks'] = Str::limit($collection->remarks, 10, '...');
      } else {
        $resultArr[$i]['remarks'] = "-";
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
    $user=Auth::guard('admin')->user();
    if($user->type==2){
      $collection = $this->model->select('extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date')
      ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')->where('extended_warranty.status', 1);
      //->where('user_assigned_list.user_id',$user->id);
  }else{
      $collection = $this->model->select('extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date')
      ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')->where('extended_warranty.status', 1);
  }
  

     if (isset($filter['search_executive_user_id'])) {
      if ($filter['search_executive_user_id'] != '') {
         $collection = $collection->where('extended_warranty.executive_user_id',$filter['search_executive_user_id']);
       }
     }

     if (isset($filter['search_assigned_user_id'])) {
      if ($filter['search_assigned_user_id'] != '') {
         $collection = $collection->where('user_assigned_list.user_id',$filter['search_assigned_user_id']);
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
        if($filter['from_date']== $filter['to_date']){
          $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
        }else{
          $collection = $collection->whereBetween('user_assigned_list.created_at', [$filter['from_date'], $filter['to_date']]);
        }
      } elseif (isset($filter['from_date'])) {
        $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
        $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
   
    } elseif (isset($filter['to_date'])) {
        $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
        $collection = $collection->where('user_assigned_list.created_at', 'like', '%' . $filter['to_date'] . '%');
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
      if($user->type==2){
        $collection = $this->model->select('extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date')
        ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')->where('extended_warranty.status', 1);
        //->where('user_assigned_list.user_id',$user->id);
    }else{
        $collection = $this->model->select('extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date')
        ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')->where('extended_warranty.status', 1);
    }

   

     if (isset($filter['search_executive_user_id'])) {
      if ($filter['search_executive_user_id'] != '') {
         $collection = $collection->where('extended_warranty.executive_user_id',$filter['search_executive_user_id']);
       }
     }

     if (isset($filter['search_assigned_user_id'])) {
      if ($filter['search_assigned_user_id'] != '') {
         $collection = $collection->where('user_assigned_list.user_id',$filter['search_assigned_user_id']);
       }
     }
     if (isset($filter['search_warranty_status'])) {
      if ($filter['search_warranty_status'] != '') {
         $collection = $collection->where('extended_warranty.warranty_status',$filter['search_warranty_status']);
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
        if($filter['from_date']== $filter['to_date']){
          $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
        }else{
          $collection = $collection->whereBetween('user_assigned_list.created_at', [$filter['from_date'], $filter['to_date']]);
        }
      } elseif (isset($filter['from_date'])) {
        $filter['from_date'] = \Carbon\Carbon::parse($filter['from_date'])->format('Y-m-d');
        $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
   
    } elseif (isset($filter['to_date'])) {
        $filter['to_date'] = \Carbon\Carbon::parse($filter['to_date'])->format('Y-m-d');
        $collection = $collection->where('user_assigned_list.created_at', 'like', '%' . $filter['to_date'] . '%');
    }
  
  

      $collection = $collection->orderby('extended_warranty.id', 'DESC')
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


  public function extendedWarrantyExport(Request $request)
  { 
    ob_end_clean();
    ob_start();
    // return Excel::download(new ExtendedWarrantyExport($request->name, $request->contact_number, $request->modal_number, $request->category_id), 'Extended_Warranty_List.xlsx');
    return Excel::download(new StaffReportExport($request->assigned_to, $request->warranty_period_from, $request->warranty_period_to, $request->search), 'Staff_Report_List.xlsx');

  }


}

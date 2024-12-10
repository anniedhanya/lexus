<?php

namespace App\Exports;

use App\Models\ExtendedWarranty;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Users;
class ExtendedWarrantyExport extends DefaultValueBinder implements WithCustomValueBinder, FromCollection, ShouldAutoSize, WithHeadings
{

  /**
   * export side
   *
   * @package        next power
   * @author         annie 
   * @copyright   Copyright (c) 2022, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/

   */

  /**

   * @return \Illuminate\Support\Collection

   */
  protected $status;

  function __construct($contact_number, $from_date, $to_date,$search,$search_executive_user_id,$search_assigned_user_id,$search_warranty_status,$search_screenshot_status,$search_order_id)
  {

    // $this->name = $name;
    $this->contact_number = $contact_number;
    // $this->modal_number = $modal_number;
    // $this->category_id = $category_id;
    $this->from_date = $from_date;
    $this->to_date = $to_date;
    $this->search = $search;
    $this->search_executive_user_id = $search_executive_user_id;
    $this->search_assigned_user_id = $search_assigned_user_id;
    $this->search_warranty_status = $search_warranty_status;
    $this->search_screenshot_status = $search_screenshot_status;
    $this->search_order_id = $search_order_id;


  }
  public function headings(): array
  {
    return [
      'Sl#',
      'Name','Contact Number','Order ID', 'Product', 'Model','Executive Name', 'Assign To', 'Warranty Status','Screenshot Status', 'Remarks','Added On','Assigned On'

    ];
  }


  public function collection()
  {
    $user_id = Auth::guard('admin')->user()->id;


    $user = Auth::guard('admin')->user();
    if($user->type == 2) {

      $collection = ExtendedWarranty::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.name as name','extended_warranty.order_id as order_id','category.category as category','extended_warranty.model_no as model_no','extended_warranty.date_of_purchase as date_of_purchase','extended_warranty.warranty_period as warranty_period','extended_warranty.warranty_period_from as warranty_period_from','extended_warranty.warranty_period_to as warranty_period_to','extended_warranty.contact_no as contact_no','extended_warranty.executive_user_id','extended_warranty.assigned_user_id','extended_warranty.warranty_status','extended_warranty.remarks','extended_warranty.created_at','extended_warranty.created_by','extended_warranty.screenshot_status')
      ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
      // ->leftjoin('user_assigned_list', 'user_assigned_list.user_id', '=', 'extended_warranty.assigned_user_id')
      ->where('extended_warranty.assigned_user_id',$user->id)
      ->orderby('extended_warranty.id', 'DESC');
    }else{

      $collection = ExtendedWarranty::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.name as name','extended_warranty.order_id as order_id','category.category as category','extended_warranty.model_no as model_no','extended_warranty.date_of_purchase as date_of_purchase','extended_warranty.warranty_period as warranty_period','extended_warranty.warranty_period_from as warranty_period_from','extended_warranty.warranty_period_to as warranty_period_to','extended_warranty.contact_no as contact_no','extended_warranty.executive_user_id','extended_warranty.assigned_user_id','extended_warranty.warranty_status','extended_warranty.remarks','extended_warranty.created_at','extended_warranty.created_by','extended_warranty.screenshot_status')
      ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
      // ->leftjoin('user_assigned_list', 'user_assigned_list.user_id', '=', 'extended_warranty.assigned_user_id')
      ->orderby('extended_warranty.id', 'DESC');
    }
   

    
     if (isset($this->name)) {
      if ($this->name != '') {
         $collection = $collection->where('name',$this->name);
       }
     }


    if (isset($this->contact_number)) {
      if ($this->contact_number != '') {
         $collection = $collection->where('contact_no',$this->contact_number);
       }
     }


    if (isset($this->modal_number)) {
      if ($this->modal_number != '') {
         $collection = $collection->where('modal_no',$this->modal_number);
       }
     }


    if (isset($this->category_id)) {
      if ($this->category_id != '') {
         $collection = $collection->where('product_category_id',$this->category_id);
       }
     }
     if (isset($this->search_executive_user_id)) {
      if ($this->search_executive_user_id != '') {
         $collection = $collection->where('executive_user_id',$this->search_executive_user_id);
       }
     }

     if (isset($this->search_assigned_user_id)) {
      if ($this->search_assigned_user_id != '') {
         $collection = $collection->where('assigned_user_id',$this->search_assigned_user_id);
       }
     }
     if (isset($this->search_warranty_status)) {
      if ($this->search_warranty_status!= '') {
         $collection = $collection->where('warranty_status',$this->search_warranty_status);
       }
     }

     if (isset($this->search_screenshot_status)) {
      if ($this->search_screenshot_status != '') {
         $collection = $collection->where('screenshot_status',$this->search_screenshot_status);
       }
     }
 
     if (isset($this->search_order_id)) {
      if ($this->search_order_id!= '') {
         $collection = $collection->where('order_id',$this->search_order_id);
       }
     }









     if (isset($this->search)) {
      if ($this->search != '') {
        $searchString_ = $this->search;
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }

    if (isset($this->search_val)) {
      if ($this->search_val != '') {
        $searchString_ = $this->search_val;
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString_ . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString_ . '%');
        });
      }
    }

    if (isset($this->from_date) && isset($this->to_date)) {
      $from_date = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
      $to_date = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');
      if($from_date== $to_date){
        $collection = $collection->where('extended_warranty.created_at', 'like', '%' . $from_date . '%');
      }else{
        $collection = $collection->whereBetween('extended_warranty.created_at', [$from_date,  $to_date]);
      }
  } elseif (isset($this->from_date)) {
      $from_date = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
      $collection = $collection->where('extended_warranty.created_at', 'like', '%' . $from_date . '%');
  } elseif (isset($this->to_date)) {
      $to_date = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');
      $collection = $collection->where('extended_warranty.created_at',  'like', '%' . $to_date . '%');
  }
  



//   if (isset($this->from_date) && isset($this->to_date)) {
//     $filter['from_date'] = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
//     $filter['to_date'] = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');

//     $collection = $collection->where(function($query) use ($filter) {
//         $query->whereBetween('extended_warranty.warranty_period_from', [$filter['from_date'], $filter['to_date']])
//               ->orWhereBetween('extended_warranty.warranty_period_to', [$filter['from_date'], $filter['to_date']]);
//     });
// } elseif (isset($this->from_date)) {
//     $filter['from_date'] = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
//     $collection = $collection->where('extended_warranty.warranty_period_from', '>=', $filter['from_date']);
// } elseif (isset($this->to_date)) {
//     $filter['to_date'] = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');
//     $collection = $collection->where('extended_warranty.warranty_period_to', '<=', $filter['to_date']);
// }


     if (isset($this->search)) {
      if ($this->search != '') {
        $searchString = $this->search;
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('extended_warranty.name', 'like', '%' . $searchString . '%')
          ->orwhere('extended_warranty.order_id', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.model_no', 'like', '%' . $searchString . '%')
            ->orWhere('extended_warranty.contact_no', 'like', '%' . $searchString . '%');
        });
      }
    }
    $collections = $collection->get();


    $collection = $collection->get();
    $newArray = array();
    $i = 1;
    foreach ($collection as  $value) {
      $warranty_status = null;
      if($value->warranty_status == 1) {
        $warranty_status  = 'Issued';
      }
      elseif($value->warranty_status == 2) {
        $warranty_status = 'Pending';
      }
      if(isset($value->executive_user_id)) {
        // $executive_user = Users::where('id', $value->executive_user_id)->first();
      //  $executive = $executive_user->name;
         $executive = $value->executive_user_id;
      } else {
        // if($value->created_by!=null) {
        //   $executive = $value->created_by;
        // }else{
        //   $executive = 'Customer';
        // }
         $executive = '';
      }
      if(isset($value->assigned_user_id)) {
        $assigned_to_user = Users::where('id', $value->assigned_user_id)->first();
        $assigned_to = $assigned_to_user->name;
      } else {
        $assigned_to = '';
      }
      $resultArr['id'] = $i;
      $resultArr['name'] = ucwords(strtolower($value->name));
      $resultArr['contact_no'] = $value->contact_no;
      $resultArr['order_id'] = $value->order_id;
      $resultArr['category'] = $value->category;

      $resultArr['model_no'] = $value->model_no;

      $resultArr['executive_name'] = $executive;
      $resultArr['assign_to'] = $assigned_to;
      $resultArr['warranty_status'] = $warranty_status;

      if(isset($value->screenshot_status)) {
      	if($value->screenshot_status == 0) {
      		$resultArr['screenshot_status'] = 'No';
      	} else if ($value->screenshot_status == 1) {
      		$resultArr['screenshot_status'] = 'Yes';
      	}
      }
      else {
      	$resultArr['screenshot_status'] = '';
      }

      $resultArr['remarks'] = $value->remarks;
      $resultArr['added_on'] =\Carbon\Carbon::parse($value->created_at)->format('d F Y');
      $resultArr['assigned_on'] =\Carbon\Carbon::parse($value->assigned_on)->format('d F Y');
      // if(isset($value->date_of_purchase)){
      // $resultArr['date_of_purchase'] =  \Carbon\Carbon::parse($value->date_of_purchase)->format('d F Y');
      // }else{
      //   $resultArr['date_of_purchase'] = "-";
      // }

      // if(isset($value->warranty_period_from)){
      //   $warranty_period_from = \Carbon\Carbon::parse($value->warranty_period_from)->format('d F Y');
      //   }else{
      //   $warranty_period_from = "";
      //   }
  
      //   if(isset($value->warranty_period_to)){
      //   $warranty_period_to = \Carbon\Carbon::parse($value->warranty_period_to)->format('d F Y');
      //   }else{
      //   $warranty_period_to = "";
      //   }
      //   $resultArr['warranty_period'] = $warranty_period_from. '----'. $warranty_period_to;
      $newArray[] = $resultArr;
      $i++;
    }
    return collect($newArray);
  }
  public function bindValue(Cell $cell, $value)
  {
    if (is_numeric($value)) {
      $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

      return true;
    }

    // else return default behavior
    return parent::bindValue($cell, $value);
  }
}

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
use App\Models\UserAssignedList;
class StaffReportExport extends DefaultValueBinder implements WithCustomValueBinder, FromCollection, ShouldAutoSize, WithHeadings
{

  /**
   * export side
   *
   * @package        ibell
   * @author         rahul 
   * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/

   */

  /**

   * @return \Illuminate\Support\Collection

   */
  protected $status;

  function __construct($assigned_to, $from_date, $to_date,$search)
  {

    $this->assigned_to = $assigned_to;
    $this->from_date = $from_date;
    $this->to_date = $to_date;
    $this->search = $search;

  }
  public function headings(): array
  {
    return [
      'Sl#',
      'Unique ID','Name','Contact Number','Order ID', 'Product', 'Model','Executive Name', 'Assign To','Assigned On', 'Warranty Status', 'Remarks','Added On'

    ];
  }


  public function collection()
  {
    $user_id = Auth::guard('admin')->user()->id;


    $user = Auth::guard('admin')->user();
    if($user->type == 2) {

      $collection = UserAssignedList::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date','category.category as category')
      ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')
      ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
      ->where('extended_warranty.assigned_user_id',$user->id)
      ->orderby('extended_warranty.id', 'DESC');
    }else{

      $collection = UserAssignedList::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.id as id','extended_warranty.name as name','extended_warranty.contact_no as contact_no','extended_warranty.order_id as order_id','extended_warranty.model_no as model_no','extended_warranty.created_at as created_at','extended_warranty.created_by as created_by','extended_warranty.product_category_id as product_category_id','extended_warranty.warranty_status as warranty_status','extended_warranty.status as status','extended_warranty.executive_user_id as executive_user_id','extended_warranty.assigned_user_id as assigned_user_id','extended_warranty.screenshot_status as screenshot_status','extended_warranty.remarks as remarks','user_assigned_list.created_at as assigned_date','category.category as category')
      ->join('extended_warranty', 'extended_warranty.id', '=', 'user_assigned_list.extended_warranty_id')
      ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
      ->orderby('extended_warranty.id', 'DESC');
    }
   

    

  
    
  

    if (isset($this->from_date) && isset($this->to_date)) {
      $filter['from_date'] = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
      $filter['to_date'] = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');
      if($filter['from_date']== $filter['to_date']){
        $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
      }else{
        $collection = $collection->whereBetween('user_assigned_list.created_at', [$filter['from_date'], $filter['to_date']]);
      }
    } elseif (isset($this->from_date)) {
      $filter['from_date'] = \Carbon\Carbon::parse($this->from_date)->format('Y-m-d');
      $collection = $collection->where('user_assigned_list.created_at',  'like', '%' . $filter['from_date'] . '%');
 
  } elseif (isset($this->to_date)) {
      $filter['to_date'] = \Carbon\Carbon::parse($this->to_date)->format('Y-m-d');
      $collection = $collection->where('user_assigned_list.created_at', 'like', '%' . $filter['to_date'] . '%');
  }







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

    if (isset($this->assigned_to)) {
      if ($this->assigned_to != '') {
         $collection = $collection->where('user_assigned_list.user_id',$this->assigned_to);
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
      // if(isset($value->executive_user_id)) {
      //   // $executive_user = Users::where('id', $value->executive_user_id)->first();
      // //  $executive = $executive_user->name;
      //    $executive = $value->executive_user_id;
      // } else {
      //   if($value->created_by!=null) {
      //     $executive = $value->created_by;
      //   }else{
      //     $executive = 'Customer';
      //   }
      //   // $executive = '';
      // }

      if(isset($value->executive_user_id)) {
         $executive = $value->executive_user_id;
      } else {
         $executive = '';
      }



      if(isset($value->assigned_user_id)) {
        $assigned_to_user = Users::where('id', $value->assigned_user_id)->first();
        $assigned_to = $assigned_to_user->name;
      } else {
        $assigned_to = '';
      }
      $resultArr['id'] = $i;
      $resultArr['unique_id'] = $value->id;
      $resultArr['name'] = ucwords(strtolower($value->name));
      $resultArr['contact_no'] = $value->contact_no;
      $resultArr['order_id'] = $value->order_id;
      $resultArr['category'] = $value->category;

      $resultArr['model_no'] = $value->model_no;

      $resultArr['executive_name'] = $executive;
      $resultArr['assign_to'] = $assigned_to;
      $resultArr['assigned_on'] =\Carbon\Carbon::parse($value->assigned_date)->format('d F Y');
      $resultArr['warranty_status'] = $warranty_status;
      $resultArr['remarks'] = $value->remarks;
      $resultArr['added_on'] =\Carbon\Carbon::parse($value->created_at)->format('d F Y');
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

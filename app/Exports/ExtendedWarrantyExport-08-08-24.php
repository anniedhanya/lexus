<?php

namespace App\Exports;

use App\Models\ExtendedWarranty;
use App\Models\Users;
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

  function __construct($name, $contact_number, $modal_number, $category_id)
  {

    $this->name = $name;
    $this->contact_number = $contact_number;
    $this->modal_number = $modal_number;
    $this->category_id = $category_id;
  }
  public function headings(): array
  {
    return [
      'Sl#',
      'Name', 'Order ID', 'Product', 'Modal', 'Executive Name', 'Assign To', 'Warranty Status', 'Remarks'

    ];
  }


  public function collection()
  {
    $user_id = Auth::guard('admin')->user()->id;



     $collection = ExtendedWarranty::select(DB::raw("@row := @row + 1 as position"),'extended_warranty.name as name','extended_warranty.order_id as order_id','category.category as category','extended_warranty.model_no as model_no','extended_warranty.executive_user_id','extended_warranty.assigned_user_id','extended_warranty.warranty_status','extended_warranty.remarks')
    ->join('category', 'category.id', '=', 'extended_warranty.product_category_id')
    ->orderby('extended_warranty.id', 'ASC');

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
        $executive_user = Users::where('id', $value->executive_user_id)->first();
        $executive = $executive_user->name;
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
      $resultArr['name'] = ucwords(strtolower($value->name));
      $resultArr['model_no'] = $value->model_no;
      $resultArr['order_id'] = $value->order_id;
      $resultArr['category'] = $value->category;
      $resultArr['executive_name'] = $executive;
      $resultArr['assign_to'] = $assigned_to;
      $resultArr['warranty_status'] = $warranty_status;
      $resultArr['remarks'] = $value->remarks;
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

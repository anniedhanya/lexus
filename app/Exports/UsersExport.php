<?php

namespace App\Exports;

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

class UsersExport extends DefaultValueBinder implements WithCustomValueBinder, FromCollection, ShouldAutoSize, WithHeadings
{

  /**
   * export side
   *
   * @package        ibell
   * @author         Rahul 
   * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
   * @link       http://www.seeroo.com/

   */

  /**

   * @return \Illuminate\Support\Collection

   */
  protected $status;

  function __construct($name, $email, $mobile_number)
  {

    $this->name = $name;
    $this->email = $email;
    $this->mobile_number = $mobile_number;
  }
  public function headings(): array
  {
    return [
      'Sl#',
      'Name', 'Email', 'Mobile Number', 'Status', 'User Type',

    ];
  }


  public function collection()
  {
    $user_id = Auth::guard('admin')->user()->id;



     $collection = Users::select(DB::raw("@row := @row + 1 as position"),'users.name as name','users.email as email','users.mobile_number as mobile_number','users.status as status','users.type as user_type')
    ->orderby('users.id', 'ASC');

    // dd($collection->get()->toArray());
     if (isset($this->name)) {
      if ($this->name != '') {
         $collection = $collection->where('name',$this->name);
       }
     }


    if (isset($this->mobile_number)) {
      if ($this->mobile_number != '') {
         $collection = $collection->where('mobile_number',$this->mobile_number);
       }
     }


    if (isset($this->email)) {
      if ($this->email != '') {
         $collection = $collection->where('email',$this->email);
       }
     }


    if (isset($this->search_val)) {
      if ($this->search_val != '') {
        $searchString_ = $this->search_val;
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('users.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('users.email', 'like', '%' . $searchString_ . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString_ . '%');
        });
      }
    }

     if (isset($this->search)) {
      if ($this->search != '') {
        $searchString = $this->search;
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('users.name', 'like', '%' . $searchString . '%')
            ->orWhere('users.email', 'like', '%' . $searchString . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString . '%');
        });
      }
    }

    $collection = $collection->get();

    $newArray = array();
    $i = 1;
    foreach ($collection as  $value) {
      $status = null;
      if($value->status == 1) {
        $status  = 'Active';
      }
      elseif($value->status == 0) {
        $status = 'Inactive';
      }

      $user_type = null;
      if($value->user_type == 1) {
        $user_type = 'Executive';
      }
      elseif($value->user_type == 2) {
        $user_type = 'Customer';
      }
      
      $resultArr['id'] = $i;
      $resultArr['name'] = ucwords(strtolower($value->name));
      $resultArr['email'] = $value->email;
      $resultArr['mobile_number'] = $value->mobile_number;
      $resultArr['status'] = $status;
      $resultArr['user_type'] = $user_type;
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

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
use App\Models\Users;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Session;


class UsersController extends BaseController
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
    $this->model = new Users;
    $this->route .= '.users';
    $this->views .= '.users';

    $this->resourceConstruct();
    $this->middleware('checkRole:users');

  }

  protected function getEntityName()
  {
    return 'Users';
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

  public function userList(Request $request)
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
      $resultArr[$i]['email'] = $collection->email;
      if($collection->type==1){
        $resultArr[$i]['type'] = "Executive";
      }else{
        $resultArr[$i]['type'] = "User";
      }
      $resultArr[$i]['contact_no'] = $collection->mobile_number;

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
    $collection = $this->model->where('status', 1)->where('type','!=',0);

    if (isset($filter['name'])) {
      if ($filter['name'] != '') {
         $collection = $collection->where('name',$filter['name']);
       }
     }


    if (isset($filter['contact_number'])) {
      if ($filter['contact_number'] != '') {
         $collection = $collection->where('mobile_number',$filter['contact_number']);
       }
     }


    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('users.name', 'like', '%' . $searchString_ . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString_ . '%')
                ->orWhere('users.email', 'like', '%' . $searchString_ . '%');
        });
      }
    }

     if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('users.name', 'like', '%' . $searchString . '%')
          ->orwhere('users.email', 'like', '%' . $searchString . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString . '%');
        });
      }
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
        $perpage = 100;
      }

      $pages = ceil($count / $perpage);
      $pages = (int) $pages;
      $offset = (($currentPage - 1) * $perpage);
      DB::enableQueryLog();
      $collection = $this->model->where('status', 1)->where('type','!=',0);

      if (isset($filter['name'])) {
      if ($filter['name'] != '') {
         $collection = $collection->where('name',$filter['name']);
       }
     }


    if (isset($filter['contact_number'])) {
      if ($filter['contact_number'] != '') {
         $collection = $collection->where('mobile_number',$filter['contact_number']);
       }
     }

 
    if (isset($filter['search_val'])) {
      if ($filter['search_val'] != '') {
        $searchString_ = $filter['search_val'];
        $collection = $collection->where(function ($query) use ($searchString_) {
          $query->where('users.name', 'like', '%' . $searchString_ . '%')
          ->orwhere('users.email', 'like', '%' . $searchString_ . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString_ . '%');
        });
      }
    }
        if (isset($filter['search'])) {
      if ($filter['search'] != '') {
        $searchString = $filter['search'];
        $collection = $collection->where(function ($query) use ($searchString) {
          $query->where('users.name', 'like', '%' . $searchString . '%')
            ->orWhere('users.email', 'like', '%' . $searchString . '%')
            ->orWhere('users.mobile_number', 'like', '%' . $searchString . '%');
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

  public function store(Request $request)
  {
    $data = Input::all();
  //   $validator = Validator::make(
  //     $data,
  //     [
  //         'name' => 'required|string|max:255',
  //         'email' => 'required_if:user_type,1|email',
  //         'contact_no' => 'required|max:15',
  //         'password' => 'required_if:user_type,1|min:8|max:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  //         'password_confirmation' => 'required_if:user_type,1|same:password|min:8|max:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  //         'status' => 'required|max:255',
  //         'user_type' => 'required',
  //     ],
  //     [
  //         'name.required' => 'Please enter a name.',
  //         'email.required_if' => 'Please enter email.',
  //         'contact_no.required' => 'Please enter a contact number.',
  //         'password.required_if' => 'The password field is required.',
  //         'password_confirmation.required_if' => 'The confirm password field is required.',
  //         'password.min' => 'The password must be at least 8 characters.',
  //         'password_confirmation.min' => 'The confirm password must be at least 8 characters.',
  //         'password.max' => 'The password must not be greater than 8 characters.',
  //         'password_confirmation.max' => 'The confirm password must not be greater than 8 characters.',
  //         'password_confirmation.same' => 'The confirm password and password must match.',
  //         'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
  //         'password_confirmation.regex' => 'The confirm password must contain at least one uppercase letter, one lowercase letter, and one number.',
  //         'status.required' => 'Please select status.',
  //         'user_type.required' => 'Please select user type.',
  //     ]
  // );
  
  $validator = Validator::make($data, [
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'contact_no' => 'required|max:15',
    'status' => 'required|max:255',
    'user_type' => 'required',
    'password' => 'required|min:8|max:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
    'password_confirmation' => 'required|same:password|min:8|max:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
]);
$validator->sometimes('email', [
  'required_if:user_type,1',
  'email'
], function ($input) {
  return $input->user_type == 1;
});
// $validator->sometimes('password', [
//     'required_if:user_type,1',
//     'min:8',
//     'max:8',
//     'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
// ], function ($input) {
//     return $input->user_type == 1;
// });

// $validator->sometimes('password_confirmation', [
//     'required_if:user_type,1',
//     'same:password',
//     'min:8',
//     'max:8',
//     'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
// ], function ($input) {
//     return $input->user_type == 1;
// });

$messages = [
    'name.required' => 'Please enter a name.',
    'email.required' => 'Please enter email.',
    'contact_no.required' => 'Please enter a contact number.',
    'password.required_if' => 'The password field is required.',
    'password_confirmation.required_if' => 'The confirm password field is required.',
    'password.min' => 'The password must be at least 8 characters.',
    'password_confirmation.min' => 'The confirm password must be at least 8 characters.',
    'password.max' => 'The password must not be greater than 8 characters.',
    'password_confirmation.max' => 'The confirm password must not be greater than 8 characters.',
    'password_confirmation.same' => 'The confirm password and password must match.',
    'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
    'password_confirmation.regex' => 'The confirm password must contain at least one uppercase letter, one lowercase letter, and one number.',
    'status.required' => 'Please select status.',
    'user_type.required' => 'Please select user type.',
];

$validator->setCustomMessages($messages);


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
        $connector_save = new Users(); 
        $connector_save['name'] = $request->name;
        $connector_save['email'] = $request->email;
        $connector_save['mobile_number'] = $request->contact_no;
        $connector_save['password'] = bcrypt($request->password);
        $connector_save['status'] = $request->status;
        $connector_save['type'] = $request->user_type;
        $connector_save->save();

      DB::commit();
      $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Users',
                             'action'=> 'User Created for '.$request->contact_no.' by '.Auth::guard('admin')->user()->name
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

  public function update($id)
  {
    $data = Input::all();

    $validator = Validator::make(Input::all(), [
      'name' => 'required|string|max:50',
      'email' => 'required|email',
      'contact_no' => 'required|max:15',
      'status' => 'required',
      'type' => 'required'
  ], 
  [
    'name.required' => 'Name field is required.',
    'email.email' => 'The email field must be a valid email address.',
    'contact_no.required' => 'Contact number field is required.',
    'status.required' => 'Please select status.',
    'type.required' => 'Please select user type.',
  ]);
  
        
    if ($validator->fails()) {
      $current_url = url('users', ['users' => $id], 'edit');
      return Redirect::back()->withInput()->withErrors($validator);
    }
 
    return $this->_update($id);
  }

  protected function _update($id)
  {
    if ($obj = $this->model->find($id)) {
      $data = Input::all();
      
    //   $user = Auth::guard('admin')->user();
    //   if($user->type == 1) {
    //     $executive_user_id = $user->id;
    //   }
    //   else {
    //     $executive_user_id = $data['executive_user_id'];
    //   }
      $this->update_data('Users', array('id' => $id), array(
              'name' => ucwords(strtolower($data['name'])),
              'email' => $data['email'],
              'mobile_number' => $data['contact_no'],
              'status' => $data['status'],
              'type' => $data['type']
            ));

   $log_arr = array('user_id'=>Auth::guard('admin')->user()->id,
                             'module'=>'Users',
                             'action'=> Auth::guard('admin')->user()->name." User Data Updated"
                            ); 
            Logs::insertLog($log_arr);
      
      return $this->redirect('Updated Successfully.');
    } else {
      return $this->redirect('notfound.', 'error');
    }
  }

  public function userDelete(Request $request)
  {
    $flag = 0;
    $obj = $this->model->find($request->id);
    if ($obj) {
      Users::where('id', $request->id)->delete();
     
      return $this->redirect('Deleted Successfully.');
    } else{
      $flag = 1;
    }
}

  public function usersExport(Request $request)
  { 
    ob_end_clean();
    ob_start();
    return Excel::download(new UsersExport($request->search), 'Users.xlsx');
  }


}

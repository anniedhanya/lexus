<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Input,DB;

class SettingsController extends Controller
{
    public function index() {
        $data = Settings::all();
        return view('Admin.settings.index', ['data' => $data]);
    }


    public function dataList(Request $request)
    {   
        $inputs = $request->all();
        $filter = $request->filter;
  
        if(isset($inputs['page_number']) && $inputs['page_number'] != "" && $inputs['page_number'] != 0)
        {
          $currentPage = $inputs['page_number'];
        }
        else
        {
          $currentPage = 1;
        }
  
        $dataArr = $this->getCollection();
        $collections = $dataArr['collection'];
        $totalCount =  $dataArr['count'];
        $totalPages = $dataArr['total_pages'];
        $offset = $dataArr['offset'];
        
        $resultArr = array();
        $i = 0;
        foreach($collections as $collection)
        {
          $resultArr[$i]['id'] = $collection->id;
          $resultArr[$i]['title'] = $collection->title;
          $resultArr[$i]['address'] = $collection->address;
          $resultArr[$i]['phone_number'] = $collection->phone_number;
          $resultArr[$i]['email'] = $collection->email;
          $resultArr[$i]['facebook'] = $collection->facebook;
          $resultArr[$i]['instagram'] = $collection->instagram;
          $resultArr[$i]['youtube'] = $collection->youtube;


         
          $i++;
        }
        $data['status']=true;
        $data['result']=$resultArr; 
        $data['count'] = $i;
        $data['total_count'] = $totalCount;
        $data['current_page'] = $currentPage;
        $data['total_pages'] = $totalPages;
        $data['offset'] = $offset;
        return response()->json($data, 200);
    }

    public function getCollection() {
        $data = Input::all();
        $filter = $data['filter'];
        DB::enableQueryLog();

        // $collection = NewSettings::query()->get();

        $collection = Settings::select('id', 'title','phone_number', 'email')->get();
        $count = $collection->count();

    if($count > 0)
    {
      if(isset($data['page_number']) && $data['page_number'] != "" && $data['page_number'] != 0)
      {
        $currentPage = $data['page_number'];
      }
      else
      {
        $currentPage = 1;
      }

      if(isset($filter['per_page_count']))
      {
        $perpage = $filter['per_page_count'];
      }
      else
      {
        $perpage = 10;
      }
      
      $pages = ceil($count/$perpage);
      $pages = (integer) $pages;
      $offset = (($currentPage - 1) * $perpage);
      DB::enableQueryLog();
      $collection = Settings::select('id', 'title', 'phone_number', 'email')
    ->skip($offset)
    ->take($perpage)
    ->get();


    }
    else
    {
      $pages = 0;
      $offset = 0;
    }

        $dataArr['collection'] = $collection;
        $dataArr['count'] = $count;
        $dataArr['offset'] = $offset;
        $dataArr['total_pages'] = $pages;
        return $dataArr;
    }


    public function edit(Settings $value) {
        return view('Admin.settings.edit', ['data' => $value]);
    }
    public function update(Settings $data, Request $request) {
        $newData = $request->validate([
            'title' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'youtube' => 'required'
        ]);

        $data->update($newData);

        return redirect(route('settings'))->with('success', 'Updated succesfully');
    }
}

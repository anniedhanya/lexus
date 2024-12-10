<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;




       public function save_data($inputarray, $modelname) {

        $model = "App\Models\\" . $modelname;

        $modelobj = new $model;
        $modelobj->fill($inputarray);
        if ($modelobj->save()) {
            $res = $modelobj->id;
        } else {
            $res = false;
        }
        return $res;
    }


       public function save_user_data($inputarray, $modelname) {

        $model = "App\\" . $modelname;

        $modelobj = new $model;
        $modelobj->fill($inputarray);
        if ($modelobj->save()) {
            $res = $modelobj->id;
        } else {
            $res = false;
        }
        return $res;
    }

       public function update_data($modelname,$wherearray, $updatearray) {

        $model = "App\Models\\" . $modelname;
        $modelobj = $model::where($wherearray)->update($updatearray);
        return $modelobj;
    }
}

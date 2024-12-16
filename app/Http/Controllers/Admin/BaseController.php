<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller, Input, File;

abstract class BaseController extends Controller {

    protected $route, $views;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

        /**
* KMCC Saudi
* This Controller is used to call specific functions
* Admin side
*
* @package          KMCC Saudi
* @author         Annie 
* @copyright   Copyright (c) 2018, Seeroo IT Solutions (p) Ltd
* @link       http://www.seeroo.com/

*/
    public function __construct()
    {
        $this->route = $this->views = 'Admin';
    }

protected function uploadFileWithDiffrenExtension($fileInput = 'image', $filePath = 'uploads/') {

      
        
        
        $destinationPath = public_path($filePath);
        
       
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Input::file($fileInput);
        $file_for_local = is_object($fileInput) ? $fileInput : Input::file($fileInput);



        if ((is_object($fileInput) || Input::hasFile($fileInput)) && $file->isValid()) {
            $fileName = strtolower($file->getClientOriginalName());

            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = $file_parts['filename'] . "-" . str_random(15);
            $i = 0;
            $extra = '';
            while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                $i++;
                $extra = '-' . $i;
            }
            $fileName = $file_name . $extra . '.' . $file_ext;


            if (!File::isDirectory($destinationPath)) {
                // path does not exist
                File::makeDirectory($destinationPath, 0755);
                //File::makeDirectory($destinationPath . "/thumb/", 0755);
            }
            
          

            if ($file->move($destinationPath, $fileName)) {
                
                $result['filepath'] = $filePath . $fileName;
               // $result['thumb'] = $thumb;
                $result['success'] = true;
                } else {
                    $result['error'] = 'No file selected or Invalid file.';
                }
               
                
                
            
        } else {
            
      
            $result['error'] = 'No file selected or Invalid file.';
        }
        return $result;
    }


    protected function uploadFileWithThumb($fileInput = 'image', $filePath = 'uploads/', $twdth = 400, $thgt = 400) {

      
        
        
        $destinationPath = public_path($filePath);
        
       
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Input::file($fileInput);
        $file_for_local = is_object($fileInput) ? $fileInput : Input::file($fileInput);



        if ((is_object($fileInput) || Input::hasFile($fileInput)) && $file->isValid()) {
            $fileName = strtolower($file->getClientOriginalName());

            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = $file_parts['filename'] . "-" . str_random(15);
            $i = 0;
            $extra = '';
            while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                $i++;
                $extra = '-' . $i;
            }
            $fileName = $file_name . $extra . '.' . $file_ext;


            if (!File::isDirectory($destinationPath)) {
                // path does not exist
                File::makeDirectory($destinationPath, 0755);
                File::makeDirectory($destinationPath . "/thumb/", 0755);
            }
            
          

            if ($file->move($destinationPath, $fileName)) {
                
               
                if (!in_array($_SERVER['SERVER_NAME'], array("localhost", "192.168.0.110"))) {

                    $image = new \Imagick($destinationPath . $fileName);
                    $image->setImageCompressionQuality(85);
                    header('Content-Type: image/png');
                    // $image->move($destinationPath, $fileName);
                    $fle = $destinationPath . "/" . $fileName;
                    file_put_contents($fle, $image);



                    $im = new \Imagick($destinationPath . $fileName);
                    $im->cropThumbnailImage($twdth, $thgt);
                    $im->setImageFormat('jpg');
                    $im->setImageCompressionQuality(85);
                    header('Content-Type: image/png');
                    // dd($destinationPath);
                    $thumb = $destinationPath . "thumb/" . $fileName;
                    file_put_contents($thumb, $im);
                } else {
                    $thumb = $destinationPath . "thumb/" . $fileName;
                    $srcPath = $destinationPath . $fileName;

                    copy($srcPath , $thumb);
                }
                $result['filepath'] = $filePath . $fileName;
                $result['thumb'] = $thumb;
                $result['success'] = true;
                
                
            }
        } else {
            
      
            $result['error'] = 'No file selected or Invalid file.';
        }
        return $result;
    }

    protected function uploadFile($fileInput = 'image', $filePath = 'uploads/') {

        $destinationPath = public_path($filePath);
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Input::file($fileInput);



        if ((is_object($fileInput) || Input::hasFile($fileInput)) && $file->isValid()) {
            $fileName = strtolower($file->getClientOriginalName());

            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = $file_parts['filename'] . "-" . str_random(15);
            $i = 0;
            $extra = '';
            while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                $i++;
                $extra = '-' . $i;
            }
            $fileName = $file_name . $extra . '.' . $file_ext;


            if (!File::isDirectory($destinationPath)) {
                // path does not exist
                File::makeDirectory($destinationPath, 0755);
            }

            if ($file->move($destinationPath, $fileName)) {
                $result['filepath'] = $filePath . $fileName;
                $result['success'] = true;
            }
        } else {
            $result['error'] = 'No file selected or Invalid file.';
        }
        return $result;
    }


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


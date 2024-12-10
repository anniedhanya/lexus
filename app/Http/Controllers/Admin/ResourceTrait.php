<?php namespace App\Http\Controllers\Admin;

use View, Input, Request, DataTables, Form, Redirect;

trait ResourceTrait {

	protected $model, $entity;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

            /**
* ILEAF
* This Controller is used to call for accessing specific functions
* Admin side
*
* @package          ILEAF
* @author         Annie 
* @copyright   Copyright (c) 2018, Seeroo IT Solutions (p) Ltd
* @link       http://www.seeroo.com/

*/
	public function resourceConstruct()
	{
		$this->entity = $this->getEntityName();

		View::share(['route' => $this->route, 'views' => $this->views, 'entity' => $this->entity]);
	}

	protected function getEntityName() {
		return class_basename($this->model);
	}

	/**
	 * Show the data list.
	 *
	 * @return Response
	 */
	public function index()
	{
            
         
            
        if (Request::ajax()) {
            $collection = $this->getCollection();
            $route = $this->route;
            return $this->setDTData($collection)->make(true);
        } else {
			return view($this->views . '.index');
        }
	}

	abstract protected function getCollection();


protected function initDTData($collection, $qs_array = []) {
       $route = $this->route;
return Datatables::of($collection)
           ->setRowId('row-{{ $id }}')
            ->addColumn('row_id', '<input type="checkbox" name="sel_ids[]" value="{{ $id }}"/>')
           ->addColumn('action_edit', function($obj) use ($route, $qs_array) {
               return '<a href="' . route( $route . '.edit',  [$obj->id] + $qs_array) . '" class="btn btn-info btn-sm" title="' . ($obj->updated_at ? 'Last updated at : ' . $obj->updated_at->format('d/m/Y - h:i a') : '') . ($obj->updated_by && $obj->lastUpdatedUser ? "&#10;By : " . $obj->lastUpdatedUser->email : "") . '" ><i class="glyphicon glyphicon-edit"></i></a>';
           })

 
        
           ->addColumn('action_delete', function($obj) use ($route, $qs_array) {
               return \Form::open(array('route' => array($route .'.destroy', $obj->id) + $qs_array , 'method' => 'delete', 'data-confirm' => 'Are you sure to delete?  Associated data will be removed if it is deleted.')) . '<button type="submit" href="' . route($route .'.destroy', [$obj->id] + $qs_array) . '" class="btn btn-danger btn-sm" title="' . ($obj->created_at ? 'Created at : ' . $obj->created_at->format('d/m/Y - h:i a') : '') . '" > <i class="glyphicon glyphicon-trash"></i></button>' . \Form::close();
           })
              
           //     ->addColumn('actions', function($obj) use ($route, $qs_array) {
           //     return '<a href="' . route( $route . '.edit',  [$obj->id] + $qs_array) . '" class="btn btn-info btn-sm" title="' . ($obj->updated_at ? 'Last updated at : ' . $obj->updated_at->format('d/m/Y - h:i a') : '') . ($obj->updated_by && $obj->lastUpdatedUser ? "&#10;By : " . $obj->lastUpdatedUser->email : "") . '" ><i class="glyphicon glyphicon-edit"></i></a>'.
           //      \Form::open(array('route' => array($route .'.destroy', $obj->id) + $qs_array , 'method' => 'delete', 'data-confirm' => 'Are you sure to delete?  Associated data will be removed if it is deleted.')) . '<button type="submit" href="' . route($route .'.destroy', [$obj->id] + $qs_array) . '" class="btn btn-danger btn-sm" title="' . ($obj->created_at ? 'Created at : ' . $obj->created_at->format('d/m/Y - h:i a') : '') . '" > <i class="glyphicon glyphicon-trash"></i></button>' . \Form::close();
           // })
           ->addColumn('actions', function($obj) use ($route, $qs_array) {
               return '<a href="' . route( $route . '.edit',  [$obj->id] + $qs_array) . '" class="btn btn-info btn-sm" title="' . ($obj->updated_at ? 'Last updated at : ' . $obj->updated_at->format('d/m/Y - h:i a') : '') . ($obj->updated_by && $obj->lastUpdatedUser ? "&#10;By : " . $obj->lastUpdatedUser->email : "") . '" ><i class="glyphicon glyphicon-edit"></i></a>';
           })
          ->rawColumns(['action_edit', 'action_delete','row_id','action_status','action_position','title','send_sms','allocated_questions','image','actions','status','action_view','action_preview','action_targetstatus','action_copy']);

       
}




	protected function setDTData($collection) {
		return $this->initDTData($collection);
	}

	/**
	 * Show the add form.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view($this->views . '.form')->with('obj', $this->model);
	}

	public function show($id)
	{
		return $this->edit($id);
	}

    public function store()
    {
          
        
    	$this->model->validate();
        return $this->_store();
    }

	protected function _store()
	{
          
		$this->model->fill($this->prepareData());
		$this->model->save();
        return $this->redirect('created');
	}

    public function edit($id) {
        if($obj = $this->model->find($id)){
            return view($this->views . '.form')->with('obj', $obj);
        } else {
            return $this->redirect('notfound', 'error');
        }
    }

    public function update($id) 
    {

    	$this->model->validate(Input::all(), $id);
        return $this->_update($id);
    }

    protected function _update($id) {
       
        if($obj = $this->model->find($id)){
        	$obj->update($this->prepareData($id));
            return $this->redirect('updated');
        } else {
            return $this->redirect('notfound', 'error');
        }
    }
    
    public function destroy($id) {
        
        $obj = $this->model->find($id);
       
        if ($obj) {
            $obj->delete();
            return $this->redirect('removed');
        }
        return $this->redirect('notfound', 'error');
    }
    
    protected function prepareData($update = false) {
    	return Input::all();
    }

    /**
     * Redirect after an operation
     * @return Redirect redirect object
     */
	protected function redirect($op, $type = 'success', $view = 'index')
	{
        if($type == 'success')
            $response = Redirect::route($this->route . '.' . $view);
        else
            $response = Redirect::back()->withInput();

        return $response->with([$type =>  trans($this->getEntityName().' ' . $op, array('entity' => $this->entity) )] );
	}

       public function updatePosition($id, $dir) {
        $obj = $this->model->find($id);
        if ($obj) {
            if($dir == 'up'){
               $pos_icon = '>';  
               $direction = 'ASC';  
            } else {
               $direction = 'DESC';
                $pos_icon = '<'; 
            }
            $obj_position = $obj->position;
            $nearest_item = $this->model->select('id', 'position')->where('position', $pos_icon, $obj->position)->orderBy('position', $direction)->first();
            // dd($nearest_item);
            if($nearest_item) {
                $obj->position = $nearest_item->position;
                $obj->update();
                $nearest_item->position = $obj_position;
                $nearest_item->update();
            }
            return $this->redirect('updated');
        }
        return $this->redirect('notfound', 'error');
    }

     public function check_template($template_id)
   {
      $check_template= ReportTemplate::join('org_report_template_activity','org_report_template_activity.template_id','=','org_report_template.id')->where('org_report_template.id',$template_id)->first();
      if(isset($check_template)){
          return true;
      }else{
          return false;
      }
   }

}

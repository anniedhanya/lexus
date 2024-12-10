<?php namespace App\Models; 
use App\Models\BaseModel, App\Models\ValidationTrait;
use Auth,DB;
use App\Models\UserDetails;
use Carbon\Carbon;

class UserAssignedList extends BaseModel {
    
    use ValidationTrait; 

    public function __construct() {
        parent::__construct();
        
        $this->__validationConstruct();
    }
  /**
   * The database table used by the model.
   *
   * @var string
   */
      /**
    * ibell warranty
    * ExtendedWarranty Model
    
    *
    * @package        ibell warranty
    * @author         Annie 
    * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
    * @link       http://www.seeroo.com/

    */
  
  protected $table = 'user_assigned_list';
 protected $fillable = array('id','user_id','extended_warranty_id','created_at','updated_at');

 
  public $uploadPath = array('thumbnails' => ''); 

  protected function setRules() {
        $this->val_rules = array( 
         
        );
  }

  protected function setAttributes() {
        $this->val_attributes = array(
           
        );
  }


  public function setMessages() {
        $this->val_errors = [

        ];
  }






     

    
}

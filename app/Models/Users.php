<?php namespace App\Models; 
use App\Models\BaseModel, App\Models\ValidationTrait;
use Auth;
use App\Models\UserDetails;

class Users extends BaseModel {
    
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
  
  protected $table = 'users';
 
  protected $fillable = [
    'id','name',
];

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

  public static function listForSelectAssigned($default = 'Select', $limit = false) {
         
    $list = [];
     if($default)
         $list[''] = $default;
     $collection = static::orderBy('id', 'ASC')->where('type',2);
     if($limit)
         $collection->take($limit);
     $list += $collection->pluck('name', 'id')->toArray();
     return $list;
}

     

    
}

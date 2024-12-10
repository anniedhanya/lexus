<?php namespace App\Models; 
use App\Models\BaseModel, App\Models\ValidationTrait;
use Auth;
use App\Models\UserDetails;

class States extends BaseModel {
    
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
    * state Model
    
    *
    * @package        ibell warranty
    * @author         Rahul 
    * @copyright   Copyright (c) 2024, Seeroo IT Solutions (p) Ltd
    * @link       http://www.seeroo.com/

    */
  
  protected $table = 'states';
 
  protected $fillable = array('id','state','status','created_at','updated_at');

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

  public static function listForSelectState($default = 'Select States', $limit = false) {
         
       $list = [];
        if($default)
            $list[''] = $default;
        $collection = static::orderBy('id', 'ASC')->where('status',1);
        if($limit)
            $collection->take($limit);
        $list += $collection->pluck('state', 'id')->toArray();
        return $list;
   }

     

    
}

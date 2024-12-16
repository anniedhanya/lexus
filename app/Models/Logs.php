<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait;
use Input,Carbon\carbon;
class Logs extends BaseModel {
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
    
    * @package    next power
    * @author     annie 
    * @copyright  Copyright (c) 2022, Seeroo IT Solutions (p) Ltd
    * @link       http://www.seeroo.com/

    */
	protected $table = 'logs';

	protected $fillable = array('id','cpo_user_id','module','created_at','updated_at','action');

    protected $dates = array();


    protected function setRules() {
        $this->val_rules = array(          
        );
    }
    public function setMessages() {
        $this->val_errors = [        
        ];
    }
    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }
	public static function insertLog($log_array)
	{
		Logs::insert($log_array);
		return true;
	}
}

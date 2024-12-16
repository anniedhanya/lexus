<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input,Str;

class BaseModel extends Model {
    
    public static function boot() {
        parent::boot();
        
        static::saving(function ($model) {
            $model->setNullWhenEmpty($model);
        });
        
        static::updating(function ($record) {
            if(isset($record->uploadPath) && is_array($record->uploadPath)) {
                foreach ($record->uploadPath as $key => $value) {
                    $field = Str::singular($key);
                    if(Input::get('remove_' . $field) == 1 || ( isset($record->attributes[$field]) && $record->{$field} && $record->isDirty($field) ) ) {
                        $record->deleteFile($record->getOriginal($field));
                    }
                }
            }
        });
        
        static::deleting(function ($record) {
            if(isset($record->uploadPath) && is_array($record->uploadPath)) {
                foreach ($record->uploadPath as $key => $value) {
                    $field = Str::singular($key);
                    if(isset($record->attributes[$field]) && $record->{$field}) {
                        $record->deleteFile($record->{$field});
                    }
                }
            }
        });
    }    
    
    protected function setNullWhenEmpty() {
        foreach ($this->attributes as $key => $value) {
            if ( trim(strip_tags($value)) == '' && (!is_bool($value)) ) {
                $this->{$key} = null;
            }
        }
    }
    
    protected function deleteFile($filePath) {
        if (is_file(public_path($filePath))) {
            unlink(public_path($filePath));
        }
    }
    
    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function lastUpdatedUser() {
        if (isset($this->attributes['updated_by'])) return $this->belongsTo('App\User', 'updated_by');
        return null;
    }

}

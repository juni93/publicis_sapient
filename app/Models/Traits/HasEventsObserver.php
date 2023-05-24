<?php

namespace App\Models\Traits;

use Closure;

trait HasEventsObserver {
    
    /*
     * booted() 
     * per caricare i globalScopes
     * 
     * beforeSave() afterSave() beforeDelete() afterDelete()
     * Shorthand per gli eventi di modelli provenienti da Trait
     * 
     * saveQuietly() deleteQuietly()
     * per salvare / cancellare senza provocare gli eventi di save() delete()
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(static::beforeSave());
        static::saved(static::afterSave());
        static::deleting(static::beforeDelete());
        static::deleted(static::afterDelete());
    }
    
    protected static function booted()
    {
        static::globalScopes();
    }
    
    protected static function globalScopes()
    {
        
    }

    protected static function beforeSave()
    {
        return function ($model) {
            
        };
    }

    protected static function afterSave()
    {
        return function ($model) {
            
        };
    }
    
    public function performQuietly(Closure $perform)
    {
        return static::withoutEvents($perform);
    }
    
    public function saveQuietly(array $options = [])
    {
        return $this->performQuietly(function() use ($options) {
            return $this->save($options);
        });
    }

    protected static function beforeDelete()
    {
        return function ($model) {
            
        };
    }
    
    protected static function afterDelete()
    {
        return function ($model) {
            
        };
    }
    
    public function deleteQuietly(array $options = [])
    {
        return $this->performQuietly(function() use ($options) {
            return isset($options["force"]) ? $this->forceDelete() : $this->delete();
        });
    }
}
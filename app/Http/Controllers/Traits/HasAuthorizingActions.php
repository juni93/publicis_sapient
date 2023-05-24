<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Auth\Access\AuthorizationException;

/**
 * Servirà nel caso di implementazioni di utenti
 */
trait HasAuthorizingActions
{
    
    protected function canIndex($model): bool
    {
        //return $this->userResolver()->can("index", $model);
        return true;
    }
    
    protected function indexForbidden()
    {
        throw new AuthorizationException(__("List of records not authorized"));
    }
    
    protected function canShow($model): bool
    {
        return true;
        //return $this->userResolver()->can("view", $model);
    }
    
    protected function showForbidden()
    {
        throw new AuthorizationException(__("No Permission to show"));
    }
    
    protected function canCreate($model): bool
    {
        return true;
        //return $this->userResolver()->can("create", $model);
    }
    
    protected function createForbidden()
    {
        throw new AuthorizationException(__("No Permission to store"));
    }
    
    protected function canEdit($model): bool
    {
        return true;
        //return $this->userResolver()->can("edit", $model);
    }
    
    protected function editForbidden()
    {
        throw new AuthorizationException(__("No Permission to edit"));
    }
    
    protected function canUpdate($model): bool
    {
        return true;
        //return $this->userResolver()->can("update", $model);
    }
    
    protected function updateForbidden()
    {
        throw new AuthorizationException(__("No Permission to update"));
    }
    
    protected function canDestroy($model): bool
    {
        //return $this->userResolver()->can("delete", $model);
        return true;
    }
    
    protected function destroyForbidden()
    {
        throw new AuthorizationException(__("No permssion to delete"));
    }
    
}

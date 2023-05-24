<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasAuthorizingActions;
use App\Models\User;
use Throwable;

abstract class ResourceController extends Controller {

    use HasAuthorizingActions;
    
    protected function userResolver(): User
    {
        return authUser();
    }

    
    protected function indexing($model, array $params = [])
    {
        if ($this->canIndex($model)) {
            $data = $model::all()->toArray();
            return $this->renderResource($data, "index", $params);
        }
        $this->indexForbidden();
    }

    protected function creating($modelClass, array $params = [])
    {
        $model = new $modelClass;
        if ($this->canCreate($model)) {
            return $this->renderForm("create", $model, $params);
        }
        $this->createForbidden();
    }

    protected function storing($request, $modelClass, array $params = [])
    {
        $model = new $modelClass;
        if ($this->canCreate($model)) {
                return $model->saveItem($request)->refresh();
        }
        $this->createForbidden();
    }

    protected function showing($model, array $params = [])
    {
        if ($this->canShow($model)) {
            return $this->renderResource($model, "show", $params);
        }
        $this->showForbidden();
    }

    protected function renderResource($data, $verb = "view", array $params = [])
    {
        return view($this->template($verb), compact("data"));
    }

    protected function renderForm($verb, $model, array $params = [])
    {
        return view($this->template($verb), array_merge(["model" => $model], $params));
    }

    protected function invalidIndex()
    {
        return $this->responseInvalid(["message" => __("Errore nella lista dei record")]);
    }

    protected function invalidDelete()
    {
        return $this->responseInvalid(["message" => __("Errore nell'eliminazione del record")]);
    }

    protected function invalidInsert()
    {
        return $this->responseInvalid(["message" => __("Errore nell'inserimento del record")]);
    }

    protected function invalidUpdate()
    {
        return $this->responseInvalid(["message" => __("Errore nell'aggiornamento del record")]);
    }
    
    protected function insertOrUpdateInvalid($insertConstraint)
    {
        return $this->{$insertConstraint ? "invalidInsert" : "invalidUpdate"}();
    }
    
    protected function invalidContent()
    {
        return $this->responsePartial(["message" => __("Nessun record trovato o aggiornato")]);
    }

    protected function modelRoute($model, $verb, $querystring = [])
    {
        try {
            $querystring = is_array($querystring) ? $querystring : [$querystring];
            if ($model->getKey()) {
                array_push($querystring, $model);
            }
            if (! count($querystring)) {
                $querystring = null;
            }
            return route($model->{$this->routeResolver()}($verb), $querystring);
        } catch (Throwable $ex) {
            return implode("/", array_filter([
                $model->toName(),
                $verb,
                is_array($querystring) ? implode("/", $querystring) : null
            ]));
        }
    }
    
    protected function routeResolver(): string
    {
        return "toRoute";
    }

}
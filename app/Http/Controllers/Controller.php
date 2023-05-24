<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Resolve the template to use in the Response, according to the controller name.action dot notation.
     *
     * @param string $action The controller action.
     * @return string|\Illuminate\Contracts\View\View
     */
    protected function template($action = "index")
    {
        return sprintf("%s.%s", strtolower($this->name()), strtolower($action));
    }

    /**
     * Get the resolved controller name.
     *
     * @return string
     */
    public function name(): string
    {
        return str_replace("Controller", '', class_basename($this));
    }
}

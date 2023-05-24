<?php



/*
* Get the currently authenticated user.
*
* @param	string  $guard
* @return	App\Models\User | boolean
*/
function authUser($guard = null)
{
   return auth($guard)->user() ?? null;
}
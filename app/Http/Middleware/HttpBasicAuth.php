<?php

namespace App\Http\Middleware;

use App\Models\App;
use Closure;

class HttpBasicAuth
{
    public function handle($request,Closure $next)
    {
        $app = App::where('id',$request->get('app_id'))->first();
        if (!$app) {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response()->json('Unauthorized App',401,$headers);
        }

        if ($request->getUser() != $app->username || $request->getPassword() != $app->password) {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response()->json('Unauthorized App',401,$headers);
        }

        return $next($request);
    }
}
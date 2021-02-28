<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\checkMockPlatform;
use App\Models\Subscription;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function __invoke(Request $request)
    {
        $expireSubscriptions = Subscription::with('device')
                                           ->whereDate('expire_date','<',date('Y-m-d'))
                                           ->where('status','!=','canceled')
                                           ->get();
        //echo $expireSubscriptions->count();
        foreach ($expireSubscriptions as $subscription) {
            checkMockPlatform::dispatch($subscription);
        }
    }
}
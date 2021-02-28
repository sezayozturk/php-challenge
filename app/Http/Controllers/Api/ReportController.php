<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = DB::select("SELECT apps.name as appName, 
                                             date(subscriptions.updated_at) as subscriptionsDate,      
                                             devices.os as devicesOS, 
                                             count(*) as totalCount,
                                             COUNT(IF(subscriptions.status = 'started', 1, null))  'StartedCount',
                                             COUNT(IF(subscriptions.status = 'renewed', 1, null))  'RenewedCount',  
                                             COUNT(IF(subscriptions.status = 'canceled', 1, null)) 'CanceledCount'   
                                      FROM devices
                                      INNER JOIN apps ON apps.id=devices.app_id 
                                      INNER JOIN subscriptions ON subscriptions.device_id=devices.id 
                                      GROUP BY appName, subscriptionsDate, devicesOS");

        return response()->json($data);
    }
}
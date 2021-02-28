<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Device;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function __invoke(PurchaseRequest $request)
    {
        $device = Device::where('client_token',$request->get('client_token'))->with('app')->first();
        if (!$device) {
            return response()->json([
                'status'  => 'error',
                'message' => __('app.no_result')
            ],412
            );
        }

        $response = Http::withBasicAuth($device->app->username,$device->app->password)
                        ->post(route('purchase.verification.'.$device->os),[
                            'app_id'  => $device->app->id,
                            'receipt' => $request->get('receipt')
                        ]);

        if ($response->failed()) {
            return response()->json([
                'status'  => 'error',
                'message' => $response->status() == 422 ? 'Invalid Receipt Code !' : $response->json()
            ],$response->status());
        }

        $responseData                = $response->json();
        $responseData['receipt']     = $request->get('receipt');
        $responseData['expire_date'] = Carbon::createFromFormat('Y-m-d H:i:s',$responseData['expire_date'],'-6')->setTimezone(config('app.timezone'));

        try{
            $subscription = Subscription::where('device_id',$device->id)->first();
            if ($subscription) {
                if ($subscription->receipt != $responseData['receipt']) {
                    // Renewed
                    $subscription->update([
                        'status'      => 'renewed',
                        'receipt'     => $responseData['receipt'],
                        'expire_date' => $responseData['expire_date'],
                    ]);
                }
            }else {
                // Started
                $data         = [
                    'device_id'   => $device->id,
                    'status'      => 'started',
                    'receipt'     => $responseData['receipt'],
                    'expire_date' => $responseData['expire_date'],
                ];
                $subscription = new Subscription($data);
                $subscription->save();
            }
        }catch (Exception $e){
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ],409);
        }

        return response()->json([
            'purchase' => 'OK',
            'token'    => $device->client_token,
            'status'   => $subscription->status,
        ]);
    }
}
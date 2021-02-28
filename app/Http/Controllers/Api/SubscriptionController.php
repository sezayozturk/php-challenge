<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function __invoke(SubscriptionRequest $request)
    {
        $clientToken = $request->get('client_token');

        $subscription = Subscription::whereHas('device',function ($query) use ($clientToken){
            $query->where('client_token','=',$clientToken);
        })->first();

        if (!$subscription) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Subscription - Not found'
            ],404);
        }

        return response()->json([
            'subscription' => 'OK',
            'status'       => $subscription->status,
        ]);
    }
}
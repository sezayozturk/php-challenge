<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Device;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $device = Device::where([
            'app_id' => $request->get('app_id'),
            'u_id'   => $request->get('u_id'),
        ]);

        if (!$device->first()) {
            $device = new Device($request->only('app_id','u_id','os','lang') + ['client_token' => Hash::make(random_bytes(64))]);
            try{
                $device->save();
            }catch (Exception $e){
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ],409);
            }
        }

        return response()->json([
            'status' => 'ok',
            'data'   => [
                'client_token' => $device->first()->client_token
            ]
        ],200);
    }
}
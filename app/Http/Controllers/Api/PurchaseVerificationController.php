<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

class PurchaseVerificationController extends Controller
{
    public function ios(Request $request)
    {
        $response = $this->checkReceiptCode($request->get('receipt'));

        return response()->json([
            'status'      => $response['status'] =='success' ? true:false,
            'message'     => $response['message'],
            'expire_date' => $response['status'] =='success' ? $this->getExpireDate() : 'null'
        ],$response['status'] =='success' ? 200 : 422);
    }

    public function android(Request $request)
    {
        $check = $this->checkReceiptCode($request->get('receipt'));

        return response()->json([
            'status'      => $check['status'],
            'message'     => $check['message'],
            'expire_date' => $check['status'] ? $this->getExpireDate() : 'null'
        ],$check['status'] ? 200 : 422);
    }

    private function checkReceiptCode($receipt)
    {
        // Rate Limit Error
        if (substr($receipt,-2) % 6 == 0) {
            return [
                'status'  => 'error',
                'message' => 'Rate Limit Error'
            ];
        }

        if (substr($receipt,-1) % 2 == 1) {
            return [
                'status'  => 'success',
                'message' => 'Receipt Code is correct'
            ];
        }else {
            return [
                'status'  => 'error',
                'message' => 'Receipt Code is not correct'
            ];
        }
    }

    private function getExpireDate()
    {
        return Carbon::now(new CarbonTimeZone('-6'))->format('Y-m-d H:i:s');
    }
}
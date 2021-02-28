<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThirdPartyAppController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status'  => 'successful',
            'message' => 'successful',
        ],200);
    }
}
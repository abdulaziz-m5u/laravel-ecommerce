<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseOk($result, $code = 200,$message = 'Success', $meta = []){
        $response = [
            'code' => $code,
            'data' => $result,
            'message' => $message,
        ];

        if($meta){
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }

    public function responseError($error, $code = 422,$errorDetails = []){
        $response = [
            'code' => $code,
            'error' => $error
        ];

        if(!empty($errorDetails)){
            $response['errorDetails'] = $errorDetails;
        }

        return response()->json($response, $code);
    }
}

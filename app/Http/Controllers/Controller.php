<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'status' => 1,
            'data'    => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'status' => 0,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

      /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendjwtResponse($result, $msg)
    {
    	$response = [
            'data' => $result,
            'msg' => $msg
        ];
        return response()->json($response, 200);
    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendjwtError($error, $errorMessages = [], $code = 400)
    {
    	$response = [
            'msg' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    } 


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendapiResponse($message, $log = '', $transfereename = '', $calibergauge = '', $quantity = '', $apptype = '')
    {
    	$response = [
            'status' => 1,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendapiError($errorMessages, $code = 400, $log = '', $transfereename = '', $calibergauge = '', $quantity = '', $apptype = '')
    {
    	$response = [
            'status' => 0,
            'message' => $errorMessages,
        ];

        return response()->json($response, $code);
    }
}
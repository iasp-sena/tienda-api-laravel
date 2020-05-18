<?php


namespace App\Http\Controllers;


abstract class ApiController extends Controller {

    public function sendResponse($result, $message, $code = '200'){
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message
        ];
        return response()->json($response, $code);
    }

    public function sendResponseCreated($result, $message){
        return $this->sendResponse($result, $message, 201);
    }

    public function sendError($error, $messages = [], $code = '400'){
        $response = [
            "success" => false,
            "data" => $messages ?? null,
            "message" => $error
        ];
        return response()->json($response, $code);
    }

}
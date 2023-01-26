<?php 
function sendSuccessResponse($status,$message,$code)
{

    $response = [
        'status' => $status,
        'message' => $message,
    ];

    return response()->json($response,$code);
}
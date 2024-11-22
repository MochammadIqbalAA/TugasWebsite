<?php

namespace Traits;

trait ApiResponsesFormatter
{
    public function successResponse($data, $message = "Success", $status = 200)
    {
        http_response_code($status);
        return json_encode([
            "status" => "success",
            "message" => $message,
            "data" => $data
        ]);
    }

    public function errorResponse($message = "Error", $status = 400, $data = null)
    {
        http_response_code($status);
        return json_encode([
            "status" => "error",
            "message" => $message,
            "data" => $data
        ]);
    }
}

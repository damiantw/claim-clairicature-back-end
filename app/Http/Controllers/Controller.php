<?php

namespace App\Http\Controllers;

use App\Enum\Error;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as LumenController;

class Controller extends LumenController
{
    protected function errorResponse(Error $error): JsonResponse
    {
        return response()->json(['message' => $error->name], 400);
    }
}

<?php

namespace App\Exceptions;

use Exception;

class ProductLimitException extends Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            "status" => false,
            "message" => $this->getMessage()
        ]);
    }
}

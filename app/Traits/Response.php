<?php

namespace App\Traits;

use App\Enums\JsonResponseTypeEnum;
use Illuminate\Http\JsonResponse;

trait Response
{
    public function jsonResponse(
        int $status = 200,
        JsonResponseTypeEnum $type = JsonResponseTypeEnum::SUCCESS,
        string $message = 'Sucesso',
        mixed $data = null,
        mixed $complements = null,
    ): JsonResponse {
        return response()->json(array_filter([
            'success' => $type === JsonResponseTypeEnum::SUCCESS,
            'message' => $message,
            'data' => $data,
            'complements' => $complements,
        ]), $status);
    }
}

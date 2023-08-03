<?php

namespace App\Exceptions;

use App\Enums\JsonResponseTypeEnum;
use Illuminate\Support\Facades\Log;

class DefaultException extends BaseException
{
    public function report()
    {
        $message = self::class . ' Fired';

        $context = [
            'where' => $this->where,
            'data' => $this->data
        ];

        if ($this->report) {
            Log::notice($message, $context);
        }
    }

    public function render()
    {
        return $this->jsonResponse(400, JsonResponseTypeEnum::ERROR, $this->message, $this->data);
    }
}

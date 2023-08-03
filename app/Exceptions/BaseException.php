<?php

namespace App\Exceptions;

use App\Traits\Response;
use Exception;
use Throwable;

class BaseException extends Exception
{
    use Response;

    public string $where;
    public mixed $data;
    public bool $report;

    public function __construct(
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null,
        string $where = '',
        bool $report = false,
        mixed $data = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->where = $where;
        $this->data = $data;
        $this->report = $report;
    }
}

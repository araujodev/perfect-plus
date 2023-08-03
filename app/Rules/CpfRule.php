<?php

namespace App\Rules;

use App\Services\DocumentService;
use Illuminate\Contracts\Validation\Rule;

class CpfRule implements Rule
{
    private DocumentService $documentService;

    public function __construct()
    {
        $this->documentService = resolve(DocumentService::class);
    }

    public function passes($attribute, $value): Bool
    {
        return $this->documentService->isCpf($value);
    }

    public function message(): String
    {
        return 'Invalid CPF';
    }
}

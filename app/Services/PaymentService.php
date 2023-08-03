<?php

namespace App\Services;

use App\Facades\PaymentOptionFacade;

class PaymentService
{
    public function __construct(private PaymentOptionFacade $paymentOptionFacade)
    {
    }

    public function createPaymentOrder(array $paymentData): array
    {
        return $this->paymentOptionFacade->handleByMethod($paymentData);
    }
}

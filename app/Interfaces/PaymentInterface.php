<?php

namespace App\Interfaces;

interface PaymentInterface
{
    public function createCustomer(array $customer): array;
    public function payBySlip(array $customer): array;
    public function payByPix(array $customer): array;
    public function genPixQrCode(string $pay_id): array;
    public function payByCreditCard(array $customer): array;
    public function tokenize(array $customer): array;
}

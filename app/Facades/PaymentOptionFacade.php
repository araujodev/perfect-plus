<?php

namespace App\Facades;

use App\Business\Product;
use App\Enums\PaymentMethodEnum;
use App\Services\CustomerService;
use App\Services\PaymentOptionService;

class PaymentOptionFacade
{
    public function __construct(
        private CustomerService $customerService,
        private PaymentOptionService $paymentOptionService
    ) {
    }

    public function handleByMethod(array $data): array
    {
        $paymentMethod = data_get($data, 'payment_method');
        $product = new Product();

        if (empty($paymentMethod)) {
            return null;
        }

        $customer = $this->getExistentCustomer(data_get($data, 'cpf'));
        if (empty($customer)) {
            $customerToCreate = [
                'full_name' => data_get($data, 'full_name'),
                'document' => data_get($data, 'cpf'),
                'phone' => data_get($data, 'phone'),
            ];
            $customer = $this->customerService->create($customerToCreate);
        }

        $output = [];
        switch ($paymentMethod) {
            case PaymentMethodEnum::BOLETO->value:
                $invoice = $this->paymentOptionService->createSlip($product, $customer);
                $output = [
                    'invoice' => $invoice->toArray(),
                    'customer' => $customer->toArray(),
                ];
                break;

            case PaymentMethodEnum::PIX->value:
                $stepOneInvoice = $this->paymentOptionService->createPix($product, $customer);
                $invoiceWithQrCode = $this->paymentOptionService->genPixQrCode($stepOneInvoice->pay_id);
                $invoiceArray = data_get($invoiceWithQrCode, 'invoice')->toArray();
                $invoice = array_merge($invoiceArray, data_get($invoiceWithQrCode, 'qr_code'));
                $output = [
                    'invoice' => $invoice,
                    'customer' => $customer->toArray(),
                ];
                break;

            case PaymentMethodEnum::CREDIT_CARD->value:
                $validity = data_get($data, 'validity_card');
                $formattedValidity = explode('/', $validity);
                $cardInfo = [
                    'holder_name' => data_get($data, 'holder_name'),
                    'card_number' => str_replace(' ', '', data_get($data, 'card_number')),
                    'expiry_month' => $formattedValidity[0],
                    'expiry_year' => $formattedValidity[1],
                    'cvv' => data_get($data, 'cvv'),
                ];
                $token = $this->paymentOptionService->tokenCreditCard($customer, $cardInfo);
                $invoice = $this->paymentOptionService->createCreditCard($product, $customer, $token);
                $output = [
                    'invoice' => $invoice,
                    'customer' => $customer->toArray(),
                ];
                break;
        }

        return $output;
    }

    private function getExistentCustomer($document)
    {

        return $this->customerService->findByDocument($document);
    }
}

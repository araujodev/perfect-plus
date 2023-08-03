<?php

namespace App\Clients;

use App\Exceptions\DefaultException;
use App\Interfaces\PaymentInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AsaasClient implements PaymentInterface
{
    const BASE_URL = 'https://sandbox.asaas.com';

    public function createCustomer(array $customer): array
    {
        $url = self::BASE_URL . '/api/v3/customers';

        $data = [
            'name' => $customer['full_name'],
            'phone' => $customer['phone'],
            'cpfCnpj' => $customer['document'],
        ];

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->post($url, $data);

        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "Cliente não foi criado",
            data: $response,
            report: true
        ));

        return $response->json();
    }

    public function payBySlip(array $data): array
    {
        $url = self::BASE_URL . '/api/v3/payments';

        $data = [
            'billingType' => 'BOLETO',
            'customer' => data_get($data, 'customer'),
            'value' => data_get($data, 'price'),
            'dueDate' => Carbon::now()->addDays(3)->format('Y-m-d'),
        ];

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->post($url, $data);


        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "Cobraça não foi criada",
            data: $response->json(),
            report: true
        ));

        return $response->json();
    }

    public function payByPix(array $data): array
    {
        $url = self::BASE_URL . '/api/v3/payments';

        $data = [
            'billingType' => 'PIX',
            'customer' => data_get($data, 'customer'),
            'value' => data_get($data, 'price'),
            'dueDate' => Carbon::now()->addDays(3)->format('Y-m-d'),
        ];

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->post($url, $data);


        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "Cobraça não foi criada",
            data: $response->json(),
            report: true
        ));

        return $response->json();
    }

    public function payByCreditCard(array $data): array
    {
        $url = self::BASE_URL . '/api/v3/payments';

        $data = [
            'billingType' => 'CREDIT_CARD',
            'customer' => data_get($data, 'customer'),
            'value' => data_get($data, 'price'),
            'dueDate' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'creditCardToken' => data_get($data, 'token'),
        ];

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->post($url, $data);


        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "Cobraça não foi criada",
            data: $response->json(),
            report: true
        ));

        return $response->json();
    }

    public function tokenize(array $data): array
    {
        $url = self::BASE_URL . '/api/v3/creditCard/tokenize';

        $data = [
            'customer' => data_get($data, 'customer.cus_id'),
            'creditCard' => [
                'holderName' => data_get($data, 'card.holder_name'),
                'number' => data_get($data, 'card.card_number'),
                'expiryMonth' => data_get($data, 'card.expiry_month'),
                'expiryYear' => data_get($data, 'card.expiry_year'),
                'ccv' => data_get($data, 'card.cvv'),
            ],
            'creditCardHolderInfo' => [
                'name' => data_get($data, 'customer.full_name'),
                'email' => 'sample@sample.com',
                'cpfCnpj' => data_get($data, 'customer.document'),
                'postalCode' => '79080-630',
                'addressNumber' => '615',
                'addressComplement' => '',
                'phone' => data_get($data, 'customer.phone'),
                'mobilePhone' => data_get($data, 'customer.phone'),
            ]
        ];

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->post($url, $data);


        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "Cartao não foi tokenizado",
            data: $response->json(),
            report: true
        ));

        return $response->json();
    }

    public function genPixQrCode(string $pay_id): array
    {
        $url = self::BASE_URL . "/api/v3/payments/$pay_id/pixQrCode";

        $response = Http::timeout(5)
            ->acceptJson()
            ->withHeader('access_token', $this->getToken())
            ->get($url);

        throw_if(!$response->successful() || $response->failed(), new DefaultException(
            message: "QrCode não foi criado",
            data: $response->json(),
            report: true
        ));

        return $response->json();
    }

    private function getToken(): string
    {
        return env('ASAAS_API_KEY', "");
    }
}

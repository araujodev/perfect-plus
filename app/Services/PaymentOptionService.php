<?php

namespace App\Services;

use App\Business\Product;
use App\Clients\AsaasClient;
use App\Enums\PaymentMethodEnum;
use App\Exceptions\DefaultException;
use App\Models\Customer;
use App\Models\Invoice;

class PaymentOptionService
{
    public function __construct(private AsaasClient $client)
    {
    }

    public function createSlip(Product $product, Customer $customer): Invoice
    {
        $response = $this->client->payBySlip([
            'customer' => $customer->cus_id,
            'price' => $product->price,
        ]);

        $invoice = Invoice::make([
            'type' => PaymentMethodEnum::BOLETO->value,
            'value' => $response['value'],
            'due_date' => $response['dueDate'],
            'customer_id' => $customer->id,
            'pay_id' => $response['id'],
            'status' => $response['status'],
            'url' => $response['bankSlipUrl'],
        ]);

        try {
            $invoice->save();
        } catch (\Throwable $th) {
            throw new DefaultException(
                message: "Invoice não foi criado",
                data: $th->getMessage(),
                report: true
            );
        }

        return $invoice;
    }

    public function createCreditCard(Product $product, Customer $customer, string $token)
    {
        $response = $this->client->payByCreditCard([
            'customer' => $customer->cus_id,
            'price' => $product->price,
            'token' => $token,
        ]);

        $invoice = Invoice::make([
            'type' => PaymentMethodEnum::CREDIT_CARD->value,
            'value' => $response['value'],
            'due_date' => $response['dueDate'],
            'customer_id' => $customer->id,
            'pay_id' => $response['id'],
            'status' => $response['status'],
        ]);

        try {
            $invoice->save();
        } catch (\Throwable $th) {
            throw new DefaultException(
                message: "Invoice não foi criado",
                data: $th->getMessage(),
                report: true
            );
        }

        return $invoice;
    }

    public function createPix(Product $product, Customer $customer): Invoice
    {
        $response = $this->client->payByPix([
            'customer' => $customer->cus_id,
            'price' => $product->price,
        ]);

        $invoice = Invoice::make([
            'type' => PaymentMethodEnum::PIX->value,
            'value' => $response['value'],
            'due_date' => $response['dueDate'],
            'customer_id' => $customer->id,
            'pay_id' => $response['id'],
            'status' => $response['status'],
        ]);

        try {
            $invoice->save();
        } catch (\Throwable $th) {
            throw new DefaultException(
                message: "Invoice não foi criado",
                data: $th->getMessage(),
                report: true
            );
        }

        return $invoice;
    }

    public function tokenCreditCard(Customer $customer, array $cardInfo): string
    {
        $response = $this->client->tokenize(
            [
                'customer' => $customer,
                'card' => $cardInfo,
            ]
        );
        return data_get($response, 'creditCardToken');
    }

    public function genPixQrCode(string $pay_id): array
    {
        $response = $this->client->genPixQrCode($pay_id);

        $invoice = Invoice::where('pay_id', $pay_id)->get()->first();
        $invoice->url = $response['payload'];

        try {
            $invoice->save();
        } catch (\Throwable $th) {
            throw new DefaultException(
                message: "Invoice com pix ocorreu um erro",
                data: $th->getMessage(),
                report: true
            );
        }

        return [
            'invoice' => $invoice,
            'qr_code' => [
                'copy_paste' => $response['payload'],
                'image' => $response['encodedImage'],
            ],
        ];
    }
}

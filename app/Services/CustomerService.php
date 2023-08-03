<?php

namespace App\Services;

use App\Clients\AsaasClient;
use App\Exceptions\DefaultException;
use App\Models\Customer;

class CustomerService
{

    public function __construct(private AsaasClient $client)
    {
    }

    public function findByDocument(string $document): ?Customer
    {
        $document = preg_replace('/[^0-9]/', '', $document);
        return Customer::where('document', $document)->get()->first();
    }

    public function create(array $data): Customer
    {
        $integrationCustomer = $this->client->createCustomer($data);

        $customer = Customer::make([
            'full_name' => data_get($integrationCustomer, 'name'),
            'document' => data_get($integrationCustomer, 'cpfCnpj'),
            'phone' => data_get($integrationCustomer, 'phone'),
            'cus_id' => data_get($integrationCustomer, 'id'),
        ]);

        try {
            $customer->save();
        } catch (\Throwable $th) {
            throw new DefaultException(
                message: "Cliente não foi criado",
                data: $th->getMessage(),
                report: true
            );
        }

        return $customer;
    }
}

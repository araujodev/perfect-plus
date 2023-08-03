<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethodEnum;
use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'payment_method' => ['required', Rule::in(PaymentMethodEnum::toArray())],
            'phone' => ['required', 'string', 'regex:/^\(?(?:[14689][1-9]|2[12478]|3[1234578]|5[1345]|7[134579])\)? ?(?:[2-8]|9[1-9])[0-9]{3}\-?[0-9]{4}$/'],
            'cpf' => ['required', 'string', new CpfRule()],
            'card_number' => 'required_if:payment_method,credit_card',
            'holder_name' => 'required_if:payment_method,credit_card',
            'validity_card' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
        ];
    }
}

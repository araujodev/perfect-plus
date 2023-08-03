<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Perfect+</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl sm:text-center">
                <img class="block mx-auto mb-6" src="{{ asset('images/logo-original.png') }}" alt="logomarca">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Checkout Perfect+
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">Será cobrado o valor de <b>R$ 189,00</b> em pagamento
                    único.
                </p>
            </div>
            <div class="isolate bg-white mt-12">
                <div class="mx-auto max-w-2xl">
                    @if ($errors->any())
                        <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md mb-4"
                            role="alert">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-1-7h2V9h-2v2zm0-4h2V5h-2v2z" />
                                    </svg></div>
                                <div>
                                    <p class="font-bold">Atenção</p>
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <form action="{{ route('order') }}" method="POST" class="mx-auto mt-2 max-w-xl sm:mt-2">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="full_name" class="block text-sm font-semibold leading-6 text-gray-900">Nome
                                Completo</label>
                            <div class="mt-2.5">
                                <input type="text" name="full_name" id="full_name" autocomplete="fullname"
                                    placeholder="Nome Completo"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="cpf"
                                class="block text-sm font-semibold leading-6 text-gray-900">CPF</label>
                            <div class="mt-2.5">
                                <input type="text" name="cpf" id="cpf" autocomplete="CPF"
                                    placeholder="000.000.000-00"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone"
                                class="block text-sm font-semibold leading-6 text-gray-900">Telefone</label>
                            <div class="mt-2.5">
                                <input type="text" name="phone" id="phone" autocomplete="Phone"
                                    placeholder="(00) 00000-0000"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <fieldset>
                                <legend class="text-sm font-semibold leading-6 text-gray-900">Forma de Pagamento
                                </legend>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Escolha uma das opcões abaixo:</p>
                                <div class="mt-6 space-y-6">
                                    <div class="flex items-center gap-x-3">
                                        <input id="boleto" type="radio" name="payment_method" value="boleto"
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        <label for="boleto"
                                            class="block text-sm font-medium leading-6 text-gray-900">Boleto</label>
                                    </div>
                                    <div class="flex items-center gap-x-3">
                                        <input id="pix" type="radio" name="payment_method" value="pix"
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        <label for="pix"
                                            class="block text-sm font-medium leading-6 text-gray-900">PIX</label>
                                    </div>
                                    <div class="flex items-center gap-x-3">
                                        <input id="credit_card" type="radio" name="payment_method" value="credit_card"
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        <label for="credit_card"
                                            class="block text-sm font-medium leading-6 text-gray-900">Cartão de
                                            Crédito</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div id="credit_card_fields" style="display: none;">
                            <div class="sm:col-span-2">
                                <label for="card_number"
                                    class="block text-sm font-semibold leading-6 text-gray-900">Número do Cartão</label>
                                <div class="mt-2.5">
                                    <input type="text" name="card_number" id="card_number" autocomplete="Card Number"
                                        placeholder="0000 0000 0000 0000"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="holder_name"
                                    class="block text-sm font-semibold leading-6 text-gray-900">Nome do Titular</label>
                                <div class="mt-2.5">
                                    <input type="text" name="holder_name" id="holder_name"
                                        autocomplete="Holder Name" placeholder="Nome Completo"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="validity_card"
                                    class="block text-sm font-semibold leading-6 text-gray-900">Validade do
                                    Cartão</label>
                                <div class="mt-2.5">
                                    <input type="text" name="validity_card" id="validity_card"
                                        autocomplete="Validade" placeholder="02/26"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="cvv"
                                    class="block text-sm font-semibold leading-6 text-gray-900">Código de Segurança
                                    (CVV)</label>
                                <div class="mt-2.5">
                                    <input type="text" name="cvv" id="cvv" autocomplete="CVV"
                                        placeholder="000"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10">
                        <button type="submit"
                            class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Pagar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        const creditCardFields = document.getElementById('credit_card_fields');

        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardFields.style.display = 'inline-block';
                } else {
                    creditCardFields.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Perfect+ Order</title>

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
                    Ordem de Pagamento Perfect+
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    <b>{{ data_get($order, 'customer.full_name') }}</b>, sua ordem de pagamento gerada com sucesso!
                    @if (data_get($order, 'invoice.type') === 'boleto')
                        <br>
                        <br>
                        <a href="{{ data_get($order, 'invoice.url') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Pagar Boleto Agora
                        </a>
                    @endif

                    @if (data_get($order, 'invoice.type') === 'pix')
                        <br>
                        <br>
                        <div>
                            <img class="block mx-auto mb-6"
                                src="data:image/png;base64, {{ data_get($order, 'invoice.image') }}" alt="QRCode" />
                            <h3>Codigo Copia e Cola Pix:</h4>
                                <p>{{ data_get($order, 'invoice.copy_paste') }}</p>
                        </div>
                    @endif

                    @if (data_get($order, 'invoice.type') === 'credit_card')
                        <br>
                        <br>
                        @if (data_get($order, 'invoice.status') === 'CONFIRMED')
                            <p>Cobrança pelo cartão de crédito confirmada.</p>
                        @endif
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>

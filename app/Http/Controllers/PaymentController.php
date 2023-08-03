<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function order(CreateOrderRequest $request)
    {
        try {
            $order = $this->paymentService->createPaymentOrder($request->safe()->all());
            return view('order', compact('order'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->data['errors']);
        }
    }
}

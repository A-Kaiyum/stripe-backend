<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentController extends Controller
{

    public function makePayment(Request $request)
    {

        Stripe::setApiKey('sk_test_51LtSJLGiXzKYuOYkMt700dVTWeL5RG1a0e870EDiLRDuzgOkT7S0ylsMKUD2epCiLS5CvZD4imEFR7xDwuiWp7xZ00gQ3CCxeJ');

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' =>  $request->amount,
                'currency' => 'usd',
                'description' => "This is test payment",
                'receipt_email' => "srabon.tfp@gmail.com",
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            return response()->json($output);
        } catch (Error $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}

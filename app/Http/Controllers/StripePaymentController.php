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


    public function makePaymentMobile(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51LtSJLGiXzKYuOYkMt700dVTWeL5RG1a0e870EDiLRDuzgOkT7S0ylsMKUD2epCiLS5CvZD4imEFR7xDwuiWp7xZ00gQ3CCxeJ');
        // Use an existing Customer ID if this is a returning customer.
        $customer = \Stripe\Customer::create();
        $ephemeralKey = \Stripe\EphemeralKey::create(
            [
                'customer' => $customer->id,
            ],
            [
                'stripe_version' => '2022-08-01',
            ]
        );
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'eur',
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
        ]);

        return response()->json([
            "hello"
        ]);
    }
}

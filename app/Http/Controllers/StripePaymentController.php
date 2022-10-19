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

        Stripe::setApiKey(env("STRIPE_SECRET_KEY"));

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
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
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
            'amount' => 5000 * 100,
            'currency' => 'bdt',
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
        ]);

        return response()->json([
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'status' => 200,
            'publishableKey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }
}

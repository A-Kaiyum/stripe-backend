<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentController extends Controller
{

    public function makePayment()
    {

        Stripe::setApiKey('sk_test_51LtSJLGiXzKYuOYkMt700dVTWeL5RG1a0e870EDiLRDuzgOkT7S0ylsMKUD2epCiLS5CvZD4imEFR7xDwuiWp7xZ00gQ3CCxeJ');

        // function calculateOrderAmount(array $items): int {
        //     // Replace this constant with a calculation of the order's amount
        //     // Calculate the order total on the server to prevent
        //     // people from directly manipulating the amount on the client
        //     return 1400;
        // }

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => 100.00 * 100.00,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

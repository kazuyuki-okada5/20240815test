<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sigHeader = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid payload', Response::HTTP_BAD_REQUEST);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        // Handle the event
        if ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            // ここで支払い成功の処理を行います
            // $paymentIntent->idなどを使用して適切な処理を行ってください

            Log::info('Payment succeeded for payment intent ' . $paymentIntent->id);
        }

        return response('Webhook handled', Response::HTTP_OK);
    }
}


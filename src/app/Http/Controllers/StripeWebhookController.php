<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    // 銀行振込処理
    public function handleWebhook(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sigHeader = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid payload', Response::HTTP_BAD_REQUEST);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                // 支払い成功時の処理
                Log::info('Payment Intent Succeeded: ' . $paymentIntent->id);
                // ここにデータベースの更新などの処理を追加
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                // 支払い失敗時の処理
                Log::error('Payment Intent Failed: ' . $paymentIntent->id);
                // 必要に応じて通知やリトライの処理を追加
                break;

                // 他のイベントタイプも必要に応じて追加できます
        }

        return response('Webhook handled', Response::HTTP_OK);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\SendgridStatistic;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SendgridWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
//        $webhook_secret = env('SENDGRID_WEBHOOK_SECRET');
//        $request_headers = $request->headers->all();
//
//        if (!isset($request_headers['X-SendGrid-Signature']) || !isset($request_headers['X-SendGrid-Signature-Ed25519'])) {
//            return response()->json(['message' => 'Invalid webhook signature'], Response::HTTP_FORBIDDEN);
//        }
//
//        $timestamp = $request_headers['X-SendGrid-Signature'][0];
//        $signature = $request_headers['X-SendGrid-Signature-Ed25519'][0];
//        $body = $request->getContent();
//
//        $payload = $timestamp . $body;
//
//        $is_valid_signature = hash_equals(hash_hmac('sha256', $payload, $webhook_secret, false), $signature);
//
//        if (!$is_valid_signature) {
//            return response()->json(['message' => 'Invalid webhook signature'], Response::HTTP_FORBIDDEN);
//        }

        $data = $request->json()->all();

        logger($data);

        foreach ($data as $item) {
            if (isset($item['category']) && is_array($item['category'])) {
                $item['category'] = implode(',', $item['category']);
            }
            $item['timestamp'] = date('Y-m-d H:i:s', $item['timestamp']);
            SendgridStatistic::create($item);
        }

        return response()->json(['message' => 'Success'], 200);

    }
}

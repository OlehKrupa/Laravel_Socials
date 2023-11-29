<?php

namespace App\Http\Controllers;

use App\Models\SendgridStatistic;
use EllipticCurve\Ecdsa;
use EllipticCurve\PublicKey;
use EllipticCurve\Signature;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendgridWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $twilioPublicKey = env('SENDGRID_WEBHOOK_SECRET');

        $headers = $request->header();

        $signatureHeader = 'x-twilio-email-event-webhook-signature';

        $signature = $headers[$signatureHeader][0];

        $url = $request->fullUrl();
        $payload = $request->getContent();

        $timestampHeader = 'x-twilio-email-event-webhook-timestamp';

        $timestamp = $headers[$timestampHeader][0];

        $publicKey = $this->convertPublicKeyToECDSA($twilioPublicKey);

        $isValidSignature = $this->verifySignature($publicKey, $payload, $signature, $timestamp);

        if (!$isValidSignature) {
            Log::error('Invalid Twilio Email Webhook Signature');
            abort(403, 'Unauthorized');
        }

        $data = $request->json()->all();

        foreach ($data as $item) {
            if (isset($item['category']) && is_array($item['category'])) {
                $item['category'] = implode(',', $item['category']);
            }
            $item['timestamp'] = date('Y-m-d H:i:s', $item['timestamp']);
            SendgridStatistic::create($item);
        }

        return response()->json(['message' => 'Success'], 200);

    }

    public function convertPublicKeyToECDSA($publicKey)
    {
        return PublicKey::fromString($publicKey);
    }

    public function verifySignature($publicKey, $payload, $signature, $timestamp)
    {
        $timestampedPayload = $timestamp . $payload;
        $decodedSignature = Signature::fromBase64($signature);

        return Ecdsa::verify($timestampedPayload, $decodedSignature, $publicKey);
    }
}

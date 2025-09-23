<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;
use Throwable;

class AfromessageSmsService
{
    protected string $endpoint;
    protected string $apiKey;
    protected string $identifier_id;
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->endpoint = config('services.afromessage.url'); 
        $this->apiKey = config('services.afromessage.key');
        $this->identifier_id = config('services.afromessage.identifier_id'); 
        $this->logger = $logger;
    }

    /**
     * Basic single send. Supports fallback GET or POST depending on provider.
     *
     * @param  string  $to
     * @param  string  $message
     * @param  array   $opts   optional: sender, unicode, callback_url, scheduled_at, client_ref
     * @return array{success:bool, response:array|null, error?:string}
     */
    public function send(string $to, string $message): array
    {
        $payload = array_filter([
            'from' => $this->identifier_id,
            // 'sender' => $opts['sender'] ?? config('app.name'), // TODO: When production
            'to' => $to,
            'message' => $message,
        ]);

        // prefer JSON POST — if provider accepts GET use fallback
        try {
            $resp = Http::acceptJson()
                ->withToken($this->apiKey)
                ->post($this->endpoint, $payload);

            if (! $resp->successful()) {
                // log and return structured error
                $this->logger->warning('Afromessage send failed', [
                    'to' => $to, 'status' => $resp->status(), 'body' => substr($resp->body(), 0, 200)
                ]);
                return ['success' => false, 'response' => $resp->json()];
            }

            return ['success' => true, 'response' => $resp->json()];
        } catch (Throwable $e) {
            $this->logger->error('Afromessage send exception', [
                'message' => $e->getMessage(), 'payload' => $payload
            ]);
            return ['success' => false, 'response' => null, 'error' => $e->getMessage()];
        }
    }
}

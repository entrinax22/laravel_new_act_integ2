<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ResendService
{
    protected string $apiKey;
    protected string $fromEmail;
    protected string $fromName;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.resend.key');
        $this->fromEmail = config('services.resend.from_email');
        $this->fromName = config('services.resend.from_name');
        $this->baseUrl = config('services.resend.base_url', 'https://api.resend.com');
    }

    public function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ]);
    }

    public function sendEmail(string $to, string $subject, string $body)
    {
        $response = $this->client()->post('/emails', [
            'from' => $this->fromEmail,
            'to' => [$to],
            'subject' => $subject,
            'html' => $body,
        ]);

        $response->throw(); 

        return $response->json();
    }
}
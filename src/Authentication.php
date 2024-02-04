<?php

namespace Ddbaidya\LaravelPaypal;

use Ddbaidya\LaravelPaypal\Paypal;
use Exception;
use Illuminate\Support\Facades\Http;

class Authentication
{
    /**
     * Paypal Information.
     *
     * @var \Ddbaidya\LaravelPaypal\Paypal
     */
    private $paypal;

    /**
     * Authentication Url.
     *
     * @var string
     */
    private $authUrl = '/oauth2/token';

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->paypal = new Paypal();
        $this->authUrl = $this->paypal->rootUrl . $this->authUrl;
    }

    /**
     * Authentication.
     *
     * @return object|boolean
     */
    public function accessToken()
    {
        $response = Http::asForm()->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->withBasicAuth($this->paypal->clientId, $this->paypal->clientSecret)
            ->post($this->authUrl, [
                'grant_type' => 'client_credentials',
            ]);

        throw_if($response->status() != 200, new Exception('Paypal Authentication Failed'));
        return $response->object()->access_token ?? false;
    }
}

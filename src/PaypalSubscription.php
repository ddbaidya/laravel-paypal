<?php

namespace Ddbaidya\LaravelPaypal;

use Exception;
use Illuminate\Support\Facades\Http;
use Facades\Ddbaidya\LaravelPaypal\Authentication;
use Str;

class PaypalSubscription
{

    /**
     * Access Token.
     *
     * @var string
     */
    private $accessToken = null;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->accessToken = Authentication::accessToken();
    }

    /**
     * Create Catalog Product.
     *
     * @return object|boolean
     */
    public function createProduct()
    {
        $product = [
            "name" => "Video Streaming Service",
            "type" => "SERVICE",
            "description" => "Video streaming service",
            "category" => "SOFTWARE",
            "image_url" => "https://example.com/streaming.jpg",
            "home_url" => "https://example.com/home"
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => (string) Str::uuid(),
        ];
        $response = Http::withToken($this->accessToken)->withHeaders($headers)->post('https://api-m.sandbox.paypal.com/v1/catalogs/products', $product);
        throw_if($response->status() != 201, new Exception('Catalog Product Create Failed!'));
        return $response->object() ?? false;
    }
}

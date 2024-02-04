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

    /**
     * Create subscription plan.
     *
     * @return object|boolean
     */
    public function createPlan($product)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => (string) Str::uuid(),
        ];

        // Define request body
        $body = [
            'product_id' => $product->id,
            'name' => 'Basic Plan',
            'description' => 'Basic plan',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'TRIAL',
                    'sequence' => 1,
                    'total_cycles' => 1,
                ],
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 2,
                    'total_cycles' => 12,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '10',
                            'currency_code' => 'USD',
                        ],
                    ],
                ],
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => '10',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 3,
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false,
            ],
        ];

        // Make HTTP request
        $response = Http::withToken($this->accessToken)->withHeaders($headers)->post('https://api-m.sandbox.paypal.com/v1/billing/plans', $body);
        throw_if($response->status() != 201, new Exception('Subscription Plan Create Failed!'));
        return $response->object() ?? false;
    }
}

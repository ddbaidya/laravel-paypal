<?php

namespace Ddbaidya\LaravelPaypal;

class Paypal
{
    /**
     * Root URL.
     *
     * @var string
     */
    public $rootUrl = '';

    /**
     * Mood.
     *
     * @var string
     */
    public $mood = 'sandbox';

    /**
     * Client ID.
     *
     * @var string
     */
    public $clientId = '';

    /**
     * Client Secret.
     *
     * @var string
     */
    public $clientSecret = '';


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mood = config('paypal.mode');
        $this->rootUrl = $this->mood == 'live' ? config('paypal.live.root_url') : config('paypal.sandbox.root_url');
        $this->clientId = config('paypal.client_id');
        $this->clientSecret = config('paypal.client_secret');
    }
}

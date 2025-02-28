<?php

use Ollyo\Task\Routes;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Ollyo\Task\Payment\PayPalClient;


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helper.php';

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', baseUrl());

$products = [
    [
        'name' => 'Minimalist Leather Backpack',
        'image' => BASE_URL . '/resources/images/backpack.webp',
        'qty' => 1,
        'price' => 120,
    ],
    [
        'name' => 'Wireless Noise-Canceling Headphones',
        'image' => BASE_URL . '/resources/images/headphone.jpg',
        'qty' => 1,
        'price' => 250,
    ],
    [
        'name' => 'Smart Fitness Watch',
        'image' => BASE_URL . '/resources/images/watch.webp', 
        'qty' => 1,
        'price' => 199,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'image' => BASE_URL . '/resources/images/speaker.webp',
        'qty' => 1,
        'price' => 89,
    ],
];
$shippingCost = 10;

$data = [
    'products' => $products,
    'shipping_cost' => $shippingCost,
    'address' => [
        'name' => 'Sherlock Holmes',
        'email' => 'sherlock@example.com',
        'address' => '221B Baker Street, London, England',
        'city' => 'London',
        'post_code' => 'NW16XE',
    ]
];

Routes::get('/', function () {
    return view('app', []);
});

Routes::get('/checkout', function () use ($data) {
    return view('checkout', $data);
});

Routes::post('/checkout', function ($request) {
    $data = [
        'order_id' => uniqid(),
        'amount' => $request['total'],
        'currency' => 'USD',
    ];

    $client = PayPalClient::client();
    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = [
        'intent' => 'CAPTURE',
        'purchase_units' => [[
            'reference_id' => $data['order_id'],
            'amount' => [
                'value' => $data['amount'],
                'currency_code' => $data['currency']
            ]
        ]],
        'application_context' => [
            'brand_name' => 'My Company Name',
            'landing_page' => 'BILLING',
            'user_action' => 'PAY_NOW',
            'return_url' => 'http://localhost:8000/thank-you', // Redirect on successful payment
            'cancel_url' => 'http://localhost:8000/payment-error' // Redirect on cancellation
        ]
    ];

    try {
        $response = $client->execute($request);
        foreach ($response->result->links as $link) {
            if ($link->rel === 'approve') {
                header('Location: ' . $link->href);
                exit;
            }
        }
    } catch (HttpException $ex) {
        echo $ex->getMessage();
    }
});

Routes::get('/thank-you', function ($request) {
    $client = PayPalClient::client();
    $orderId = $_GET['token'];

    $request = new OrdersCaptureRequest($orderId);
    $request->prefer('return=representation');

    try {
        $response = $client->execute($request);

        if ($response->statusCode === 201 || $response->result->status === 'COMPLETED') {
            $data = [
                'order_id' => $response->result->id,
            ];
            return view('success', $data);
        }
    } catch (\PayPalHttp\HttpException $ex) {
        $errorMessage = $ex->getMessage();
        return view('error', ['errorMessage' => $errorMessage]);

    }
});

Routes::get('/payment-error', function ($request) {
    $errorMessage = isset($request['error']) ? $request['error'] : 'An unknown error has occurred.';
    return view('error', ['errorMessage' => $errorMessage]);
});

Routes::post('/subscribe', function ($request) {
$planId = $request['plan_id'];
if (empty($planId)) {
    return view('error', ['errorMessage' => 'Plan ID is required']);
}
    $client = PayPalClient::client();

});

$route = Routes::getInstance();
$route->dispatch();
?>

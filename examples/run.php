<?php
require __DIR__ . '/../vendor/autoload.php';


use MyCompany\MTLSHmac\Config;
use MyCompany\MTLSHmac\Client;

// Load configuration from project root .env
$config = new Config(__DIR__ . '/../');

$endpoint = $config->get('API_ENDPOINT', 'https://client.badssl.com/');
$params = [
    'transaction_id' => '12345',
    'amount' => '99.99',
    'currency' => 'USD'
];


$client = new Client($config);


try {
    $responseBody = $client->get($endpoint, $params, 'X-Signature');
    echo "Response from API (truncated):\n";
    echo substr($responseBody, 0, 500) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
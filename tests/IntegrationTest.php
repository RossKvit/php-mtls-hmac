<?php
use PHPUnit\Framework\TestCase;
use MyCompany\MTLSHmac\Config;
use MyCompany\MTLSHmac\Client;


final class IntegrationTest extends TestCase
{
    public function testGetWithMtlsAndHmacAgainstBadSsl()
    {
        $config = new Config(__DIR__ . '/../');

        $cert = $config->get('MTLS_CLIENT_CERT');
        $key = $config->get('MTLS_CLIENT_KEY');
        $secret = $config->get('HMAC_SECRET');
        $endpoint = $config->get('API_ENDPOINT', 'https://client.badssl.com/');

        if (empty($cert) || empty($key) || empty($secret)) {
            $this->markTestSkipped('Integration test skipped - set MTLS_CLIENT_CERT, MTLS_CLIENT_KEY and HMAC_SECRET in .env to run.');
        }

        $client = new Client($config);
        $params = ['transaction_id' => '12345', 'amount' => '99.99', 'currency' => 'USD'];
        $body = $client->get($endpoint, $params, 'X-Signature');

        $this->assertIsString($body);
        $this->assertNotEmpty($body);
    }
}
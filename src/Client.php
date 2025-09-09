<?php
namespace MyCompany\MTLSHmac;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;


class Client
{
    private Config $config;
    private GuzzleClient $http;
    private string $hmacSecret;


    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->hmacSecret = $this->config->get('HMAC_SECRET', '');


        $cert = $this->config->get('MTLS_CLIENT_CERT');
        $key = $this->config->get('MTLS_CLIENT_KEY');
        $keyPass = $this->config->get('MTLS_CLIENT_KEY_PASSPHRASE');
        $ca = $this->config->get('MTLS_CA_BUNDLE', true);


        $guzzleOptions = [
            'timeout' => 30,
            'verify' => $ca ?: true,
        ];

        if ($cert) {
            if ($keyPass) {
                $guzzleOptions['cert'] = [$cert, $keyPass];
            } else {
                $guzzleOptions['cert'] = $cert;
            }
        }
        if ($key) {
            $guzzleOptions['ssl_key'] = $key;
        }


        $this->http = new GuzzleClient($guzzleOptions);
    }

    /**
     * Send GET request with HMAC signature.
     * Returns response body string on 2xx, throws on other codes or transport errors.
     *
     * @param string $url
     * @param array $params one-dimensional array
     * @param string $signatureHeader header name to attach signature (default X-Signature)
     *
     * @return string
     */
    public function get(string $url, array $params = [], string $signatureHeader = 'X-Signature'): string
    {
        if (empty($this->hmacSecret)) {
            throw new \InvalidArgumentException('HMAC secret not configured (HMAC_SECRET)');
        }


        $signature = Signer::computeSignature($params, $this->hmacSecret);


        try {
            $response = $this->http->request('GET', $url, [
                'query' => $params,
                'headers' => [
                    $signatureHeader => $signature,
                    'Accept' => 'application/json, text/plain, */*'
                ],
            ]);
        } catch (RequestException $e) {
            $msg = $e->getMessage();
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $status = $res->getStatusCode();
                throw new \RuntimeException(sprintf('HTTP error %d: %s', $status, (string)$res->getBody()));
            }
            throw new \RuntimeException('Transport error: ' . $msg);
        }


        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException('Unexpected HTTP status code: ' . $status);
        }


        return (string)$response->getBody();
    }
}
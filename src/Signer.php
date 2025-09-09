<?php
namespace MyCompany\MTLSHmac;


class Signer
{
    /**
     * Compute HMAC signature for a one-dimensional array payload.
     * Uses canonicalization: sort keys alphabetically, build query string (key=value&...)
     * Returns lowercase hex string of HMAC-SHA256.
     */
    public static function computeSignature(array $payload, string $secret): string
    {
        $filtered = [];
        foreach ($payload as $k => $v) {
            if ($v === null) continue;
            $filtered[(string)$k] = (string)$v;
        }


        ksort($filtered);
        $pairs = [];
        foreach ($filtered as $k => $v) {
            $pairs[] = rawurlencode($k) . '=' . rawurlencode($v);
        }
        $canonical = implode('&', $pairs);


        return hash_hmac('sha256', $canonical, $secret);
    }
}
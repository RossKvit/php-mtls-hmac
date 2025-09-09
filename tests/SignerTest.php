<?php
use PHPUnit\Framework\TestCase;
use MyCompany\MTLSHmac\Signer;


final class SignerTest extends TestCase
{
    public function testComputeSignatureProducesExpectedForSortedQuery()
    {
        $payload = ['transaction_id' => '12345', 'amount' => '99.99', 'currency' => 'USD'];
        $secret = 's3cr3t';


// canonical string should be: amount=99.99&currency=USD&transaction_id=12345
        $expectedCanonical = 'amount=99.99&currency=USD&transaction_id=12345';
        $expected = hash_hmac('sha256', $expectedCanonical, $secret);


        $actual = Signer::computeSignature($payload, $secret);
        $this->assertEquals($expected, $actual);
    }
}
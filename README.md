

````markdown
# PHP mTLS + HMAC client


Minimal Composer package demonstrating:


- mTLS client configuration using Guzzle
- HMAC-SHA256 signature computation over canonical query string
- PSR-4 autoloading, .env configuration via vlucas/phpdotenv
- Unit and integration tests (integration test uses badssl client endpoint)


## Setup


1. Copy files into a directory and run `composer install`.
2. Create a `.env` file (copy `.env.example`) and set the real paths/secrets.


Example `.env` for testing with badssl (download certs from https://badssl.com/download/):


```ini
MTLS_CLIENT_CERT=./certs/badssl.com-client-cert.pem
MTLS_CLIENT_KEY=./certs/badssl.com-client-key.pem
MTLS_CLIENT_KEY_PASSPHRASE=badssl.com
HMAC_SECRET=your_shared_hmac_secret
API_ENDPOINT=https://client.badssl.com/
```


3. Run unit tests: `./vendor/bin/phpunit --filter SignerTest`
4. Run integration test (if `.env` contains real cert/key/secret): `./vendor/bin/phpunit --filter IntegrationTest`


## Notes


- Guzzle options set `cert` and `ssl_key`. If your private key is encrypted, set `MTLS_CLIENT_KEY_PASSPHRASE`.
- `verify` defaults to system CA if `MTLS_CA_BUNDLE` not set. To force validation with a specific bundle, set `MTLS_CA_BUNDLE` to the path to your CA bundle.
- The Signer canonicalizes by sorting keys and building an RFC3986-encoded query string, then computing HMAC-SHA256.


## Recommended extras


- Add more robust request/response logging (PSR-3)
- Add retries and circuit-breaker logic for production usage
- Add a convenient command-line script or small example script to demonstrate calling the client
````


---


## Final notes


This package is structured for testability: Signer is pure and unit-testable; Client depends on Config and Guzzle. The integration test is intentionally skipped unless environment variables are set so CI won't fail.
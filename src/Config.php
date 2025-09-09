<?php
namespace MyCompany\MTLSHmac;


use Dotenv\Dotenv;


class Config
{
    private array $data;


    public function __construct(string $path = null)
    {
        $dotEnvPath = $path ?? getcwd();
        if (file_exists($dotEnvPath . DIRECTORY_SEPARATOR . '.env')) {
            $dotenv = Dotenv::createImmutable($dotEnvPath);
            $this->data = $dotenv->load();
        } else {
            $this->data = $_ENV;
        }
    }


    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? getenv($key) ?: $default;
    }
}
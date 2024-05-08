<?php

namespace App\Framework\Api;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\RequestException;

class Client
{
    protected Guzzle $guzzle;
    private string $host = 'ts-bo-nginx:80/api/';

    public function __construct()
    {
        $this->guzzle = new Guzzle(['base_uri' => $this->host]);
    }

    private function call(string $method, string $uri, array $parameters): array
    {
        if (array_key_exists('headers', $parameters)) {
            $parameters['headers'] += $this->collectHeaders();
        }

        try {
            $response = $this->guzzle->request($method, $uri, $parameters);

            $body = $response->getBody();
            $content = $body->getContents();

            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (RequestException $e) {
            return json_decode($e->getMessage(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            return json_decode($e->getMessage(), true, 512, JSON_THROW_ON_ERROR);
        }
        return $data;
    }

    protected function collectHeaders(): array
    {
        $headers = [];

        //    $headers += ['Authorization' => $this->jwtBearer->generateTimeAuthorizationHeader('GW')];


        if ($this->host) {
            $headers += ['x-host' => $this->host];
        }

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $headers += ['x-user-agent' => $_SERVER['HTTP_USER_AGENT']];
        }

        if (!empty($_SERVER['HTTP_ORIGIN'])) {
            $headers += ['Origin' => $_SERVER['HTTP_ORIGIN']];
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $headers += ['Referer' => $_SERVER['HTTP_REFERER']];
        }

        if (!empty($_SERVER['HTTP_X_TRACKING'])) {
            $headers += ['x-tracking' => $_SERVER['HTTP_X_TRACKING']];
        }

        return $headers;
    }

    public function get(string $path, array $parameters = [], array $headers = []): array
    {
        return $this->call('GET', $path, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
    }

    public function postJson($path, array $parameters = [], array $headers = []): array
    {
        return $this->call('POST', $path, [
            'json' => $parameters,
            'headers' => $headers,
        ]);
    }

}

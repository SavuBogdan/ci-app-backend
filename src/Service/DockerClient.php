<?php

namespace App\Service;

use CurlHandle;

class DockerClient
{

    private CurlHandle $curlClient;

    private $socketPath;

    private $curlError = null;


    public function __construct(string $socketPath)
    {
        $this->curlClient = curl_init();
        $this->socketPath = $socketPath;

        curl_setopt($this->curlClient, CURLOPT_UNIX_SOCKET_PATH, $socketPath);
        curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
    }


    public function __destruct()
    {
        curl_close($this->curlClient);
    }

    private function generateRequestUri(string $requestPath): string
    {
        /* Please note that Curl doesn't use http+unix:// or any other mechanism for
         *  specifying Unix Sockets; once the CURLOPT_UNIX_SOCKET_PATH option is set,
         *  Curl will simply ignore the domain of the request. Hence why this works,
         *  despite looking as though it should attempt to connect to a host found at
         *  the domain "unixsocket". See L14 where this is set.
         *
         *  @see Client.php:L14
         *  @see https://github.com/curl/curl/issues/1338
         */
        return sprintf("http://unixsocket%s", $requestPath);
    }


    public function dispatchCommand(string $endpoint, array $parameters = null): array
    {
        curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));

        if (!is_null($parameters)) {
            $payload = json_encode($parameters);
            curl_setopt($this->curlClient, CURLOPT_POSTFIELDS, $payload);
        }

        $result = curl_exec($this->curlClient);

        if ($result === false) {
            $this->curlError = curl_error($this->curlClient);
            return array();
        }

        return json_decode($result, true);
    }


    public function getCurlError(): ?false
    {
        return is_null($this->curlError) ? false : $this->curlError;
    }
}
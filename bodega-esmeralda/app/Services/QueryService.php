<?php

namespace App\Services;

use App\Http\Controllers\ApiTestController;
use Illuminate\Support\Facades\Log;

class QueryService
{
    //todo this should be loaded from the database not a const!
    public const CONTRACT_ID = 1;
    public const DEFAULT_TOKEN_TYPE = 'Bearer';
    public const DEFAULT_QUERY_HOST = 'http://127.0.0.1';
    public const DEFAULT_QUERY_PORT = '8002';

    //todo this should be loaded from the database not a const!
    public const HUMIDITY_ID = 1;
    public const TEMPERATURE_ID = 10;

    public const TEMPERATURE_HOUR_QUERY_ID = 10;
    public const HUMIDITY_HOUR_QUERY_ID = 11;

    public function __construct(
        private string $email = 'cm444@test.com',
        private string $password = 'commercieel4'
    )
    {

    }

    private string $accessToken = "";
    private string $tokenType = self::DEFAULT_TOKEN_TYPE;

    private static function getURL(): string{
        $host = self::getHost();
        $port = self::getPort();
        return "$host:$port";
    }
    private static function getHost(): string{
        return env('QUERY_HOST',self::DEFAULT_QUERY_HOST);
    }
    private static function getPort(): string{
        return env('QUERY_PORT',self::DEFAULT_QUERY_PORT);
    }
    private static function getTokenType(): string{
        return env('QUERY_TOKEN_TYPE',self::DEFAULT_TOKEN_TYPE);
    }



    public function login(): void{
        $loginOptions = [
            'http' => [
                'method' => 'POST',
            ],
        ];

        $loginContext = stream_context_create($loginOptions);
        $url = self::getURL();
        $completeUrl = "$url/api/IWA/contracten/login?email=$this->email&password=$this->password";
        $resultLogin = file_get_contents(
            $completeUrl,
            false, $loginContext);

        $resultObj = json_decode($resultLogin);

        $this->accessToken = $resultObj->access_token;
        $this->tokenType = $resultObj->token_type;
    }

    public function isLoggedIn(): bool
    {
        return !($this->tokenType === "" || $this->accessToken === "");
    }

    /**
     * @throws \Exception
     */
    public function logout(): void
    {
        if (!$this->isLoggedIn())
            throw new \Exception("Access token or token type not provided (probably because it hasn't been logged in yet)");
        $logoutOptions = [
            'http' => [
                'header' => "Authorization: {$this->tokenType} {$this->accessToken}",
                'method' => 'POST',
            ],
        ];

        $logoutContext = stream_context_create($logoutOptions);
        $url = self::getURL();
        $resultLogin = file_get_contents(
            "$url/api/IWA/contracten/logout",
            false, $logoutContext);

        $this->tokenType = self::DEFAULT_TOKEN_TYPE;
        $this->accessToken = "";
    }

    /**
     * @throws \Exception
     */
    public function query(int $id, array $args = []): string
    {
        if (!$this->isLoggedIn())
            throw new \Exception("Access token or token type not provided (probably because it hasn't been logged in yet)");
        $dataOptions = [
            'http' => [
                'header' => "Authorization: {$this->tokenType} {$this->accessToken}",
                'method' => 'GET',
            ],
        ];

        $dataContext = stream_context_create($dataOptions);

        $contractId = self::CONTRACT_ID;

        $queryParameters = count($args) <= 0 ? "" : self::toQueryParameters($args);

        $url = self::getURL();
        $completeUrl = "$url/api/IWA/contracten/{$contractId}/{$id}?$queryParameters";
        return file_get_contents($completeUrl, false, $dataContext);
    }

    public function queryTemperaturesOfCurrentDayAndHour()
    {
        $hour = now()->hour;
        return $this->queryTemperaturesOfCurrentDayWithHour($hour);

    }
    public function queryTemperaturesOfCurrentDayWithHour($hour)
    {
        $date = now()->toDateString();
        $time = date("$hour:00:00");

        $queries = ["date" => $date, "time" => $time];
        return $this->query(self::TEMPERATURE_HOUR_QUERY_ID, $queries);

    }
    public function queryHumidityOfCurrentDay()
    {
        $date = now()->toDateString();
        $queries = ["date" => $date];

        return $this->query(self::HUMIDITY_HOUR_QUERY_ID, $queries);

    }

    private static function toQueryParameters(array $args): string
    {
        $result = "";
        foreach ($args as $key => $value) {
            $result = "$result&$key=$value";
        }
        return $result;
    }
}

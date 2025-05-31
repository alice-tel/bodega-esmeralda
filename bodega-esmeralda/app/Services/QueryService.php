<?php

namespace App\Services;

use App\Http\Controllers\ApiTestController;

class QueryService
{
    //todo this should be loaded from the database not a const!
    public const CONTRACT_ID = 1;
    public const DEFAULT_TOKEN_TYPE = 'Bearer';

    //todo this should be loaded from the database not a const!
    public const HUMIDITY_ID = 1;
    public const TEMPERATURE_ID = 10;

    public const TEMPERATURE_HOUR_QUERY_ID = 10;

    private string $url = 'http://127.0.0.1:8002';

    public function __construct(
        private string $email = 'email=cm444@test.com',
        private string $password = 'commercieel4'
    )
    {

    }

    private string $accessToken = "";
    private string $tokenType = self::DEFAULT_TOKEN_TYPE;


    public function login(): void{
        $loginOptions = [
            'http' => [
                'method' => 'POST',
            ],
        ];

        $loginContext = stream_context_create($loginOptions);

        $resultLogin = file_get_contents(
            "$this->url/api/IWA/contracten/login?$this->email&password=$this->password",
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

        $resultLogin = file_get_contents(
            "$this->url/api/IWA/contracten/logout",
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


        return file_get_contents("$this->url/api/IWA/contracten/{$contractId}/{$id}$queryParameters", false, $dataContext);
    }

    public function queryTemperaturesOfCurrentDayAndHour()
    {
        $date = now()->toDateString();
        $hour = now()->hour;
        $time = date("$hour:00:00");

        $queries = ["date" => $date, "time" => $time];

        return $this->query(self::TEMPERATURE_HOUR_QUERY_ID, $queries);

    }

    private static function toQueryParameters(array $args): string
    {
        $result = "?";
        foreach ($args as $key => $value) {
            $result = "$result&$key=$value";
        }
        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use function PHPUnit\Framework\isEmpty;

class ApiRequestController extends Controller
{
    //todo this should be loaded from the database not a const!
    public const CONTRACT_ID = 1;
    public const DEFAULT_TOKEN_TYPE = 'Bearer';

    //todo this should be loaded from the database not a const!
    public const HUMIDITY_ID = 1;
    public const TEMPERATURE_ID = 2;

    public function __construct(
        private string $accessToken = "",
        private string $tokenType = self::DEFAULT_TOKEN_TYPE,
    )
    {
    }

    public function login(): void{
        $loginOptions = [
            'http' => [
                'method' => 'POST',
            ],
        ];

        $loginContext = stream_context_create($loginOptions);

        $resultLogin = file_get_contents(
            'http://127.0.0.1:8002/api/IWA/contracten/login?email=cm444@test.com&password=commercieel4',
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
            'http://127.0.0.1:8002/api/IWA/contracten/logout',
            false, $logoutContext);

        $this->tokenType = self::DEFAULT_TOKEN_TYPE;
        $this->accessToken = "";
    }

    /**
     * @throws \Exception
     */
    public function query($id): string
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


        return file_get_contents("http://127.0.0.1:8002/api/IWA/contracten/{$contractId}/{$id}", false, $dataContext);
    }

}

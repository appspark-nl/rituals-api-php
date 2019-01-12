<?php

namespace RitualsApi;

use GuzzleHttp\Client;

class Rituals
{
    private $baseUrl = 'https://rituals.sense-company.com';
    private $client;

    private $username;
    private $password;

    private $user;
    private $hubs = [];

    public function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->client = new Client([
            'base_uri' => $this->baseUrl
        ]);

        $this->login();
    }

    private function login()
    {
        $body = ['email' => $this->username,'password' => $this->password];
        $response = $this->client->request('POST','/ocapi/login',[
            'json' => $body
        ]);
        $returnBody = json_decode((string)$response->getBody());

        if($returnBody->logged_id == 0)
            throw new \Exception($returnBody->error);

        $this->user = new User($returnBody);
    }

    public function getHubs()
    {
        if(count($this->hubs) > 0)
            return $this->hubs;

        return $this->refreshHubs();
    }

    public function refreshHubs()
    {
        $response = $this->client->request('GET','/api/account/hubs/'.$this->user->token);
        $returnBody = json_decode((string)$response->getBody());

        foreach($returnBody as $hubData)
            $this->hubs[] = new Hub($hubData);

        return $this->hubs;
    }

    public function turnOff(Hub $hub)
    {
        $this->changeHubState($hub,0);
    }

    public function turnOn(Hub $hub)
    {
        $this->changeHubState($hub,1);
    }

    private function changeHubState(Hub $hub,$state)
    {
        $body = ['hub' => $hub->hash,'json' => ['attr' => ['fanc' => $state == 1 ? "1" : "0"]]];
        $this->client->request('POST','/api/hub/update/attr',[
            'form_params' => $body
        ]);

        $hub->state = $state;
    }
}
<?php

namespace RitualsApi;

class User
{

    public $username;
    public $accountId;
    public $firstName;
    public $lastName;
    public $birthdate;
    public $token;

    public function __construct($user)
    {
        $this->username = $user->email;
        $this->accountId = $user->account_id;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->birthdate = $user->birthday;
        $this->token = $user->account_hash;
    }
}
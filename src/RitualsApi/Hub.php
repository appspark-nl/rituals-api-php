<?php

namespace RitualsApi;

class Hub
{

    public $roomName;
    public $battery;
    public $state;
    public $hash;


    public function __construct($hubData)
    {
        $this->roomName = $hubData->hub->attributes->roomnamec;
        $this->battery = $hubData->hub->sensors->battc->title;
        $this->state = (int)$hubData->hub->attributes->fanc;
        $this->hash = $hubData->hub->hash;
    }

}
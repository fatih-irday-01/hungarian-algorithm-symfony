<?php


namespace App\Service\Providers;


final class ProviderAll
{

    private $providers = [
        Packets\provider1::class,
        Packets\provider2::class,
    ];


    public function getResponse(){

        foreach ($this->providers as $provider) {
            $cli = new $provider;
            print_r($cli->getData());
        }

    }







}
<?php


namespace App\Service\Providers;


final class ProviderAll
{

    private $providers = [
        Packets\provider1::class,
        Packets\provider2::class,
    ];


    public function getResponse(){
        $datas = [];
        foreach ($this->providers as $provider) {
            $cli = new $provider;
            $newData = $cli->getData();
            $datas = array_merge($datas , $newData);
        }

        return $datas;
    }







}
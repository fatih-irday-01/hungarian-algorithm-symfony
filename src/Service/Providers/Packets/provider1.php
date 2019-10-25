<?php


namespace App\Service\Providers\Packets;


use App\Service\Providers\ProviderInterface;
use Symfony\Component\HttpClient\HttpClient;



class provider1 implements ProviderInterface
{

    const url = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';
    private $content = null;
    private $data = [];


    public function __construct()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', self::url);
        $this->content = $response->toArray();
    }


    public function getData(): array {

        foreach ($this->content as $item) {
            $key = key($item);
            $this->data[] = [
                'name' => $key,
                'sort_name' => ltrim($key,'Business Task '),
                'level' => $item[$key]['level'],
                'duration' => $item[$key]['estimated_duration'],
            ];
        }

        return $this->data;

    }


}
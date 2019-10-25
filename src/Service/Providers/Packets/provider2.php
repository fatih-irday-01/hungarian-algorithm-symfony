<?php


namespace App\Service\Providers\Packets;
use App\Service\Providers\ProviderInterface;
use Symfony\Component\HttpClient\HttpClient;



class provider2 implements ProviderInterface
{

    const url = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';

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
            $this->data[] = [
                'name' => $item['id'],
                'level' => $item['zorluk'],
                'duration' => $item['sure'],
            ];
        }

        return $this->data;

    }


}
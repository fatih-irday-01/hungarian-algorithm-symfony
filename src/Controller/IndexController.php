<?php

namespace App\Controller;

use App\Service\Providers\ProviderAll;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;




class IndexController extends AbstractController
{
    /**
     * @Route("/page", name="Index")
     */
    public function index()
    {
        return $this->render('Index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    /**
     * @Route("/page1", name="Index1")
     */
    public function index1()
    {

        $client = new providerAll();
        print_r($client->getResponse());
        exit();
    }
}

<?php

namespace App\Controller;

use App\Repository\DevelopersRepository;
use App\Repository\JobsRepository;
use App\Service\JobServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{



    /**
     * @Route("/", name="Index")
     */
    public function index(DevelopersRepository $developersRepository, JobsRepository $jobsRepository)
    {

        $jobs = new JobServices($developersRepository,$jobsRepository);
        $jobs->createMatris();


        exit();

    }




    /**
     * @Route("/deneme", name="Demo")
     */
    public function deneme()
    {
        $originalArray = [
            1,2,3,4,5,6,7,8,9,10
        ];
        $newArray = array_chunk($originalArray, 5);

        print_r($newArray);

        exit();

    }
}

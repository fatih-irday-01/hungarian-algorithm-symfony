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

        $jobs = new JobServices();

        $jobs->developerRunTime = 45;
        $jobs->jobs = $jobsRepository->findBy([], ['level'=>'asc']);
        $jobs->developers = $developersRepository->findBy([], ['ability'=>'asc']);
        $e = $jobs->atamaYap();

        print_r($e);

        exit();

    }




    /**
     * @Route("/deneme", name="Demo")
     */
    public function deneme()
    {



        exit();

    }
}

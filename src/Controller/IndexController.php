<?php

namespace App\Controller;

use App\Repository\DevelopersRepository;
use App\Repository\JobsRepository;
use App\Repository\DevelopersJobsRepository;

use App\Service\JobToDeveloperServices;
use Hungarian\Hungarian;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{


    /**
     * @Route("/", name="Index")
     */
    public function index(DevelopersRepository $developersRepository, JobsRepository $jobsRepository, DevelopersJobsRepository $developersJobsRepository)
    {

        $developers = $developersRepository->findAll();
        $jobs       = $jobsRepository->findAll();

        $jobs = new JobToDeveloperServices($developers,$jobs);
        $result = $jobs->jobsToDeveloper();

        dd($result);

        exit();

    }




    /**
     * @Route("/deneme", name="Demo")
     */
    public function deneme()
    {
        $originalArray = [

            [7, 12, 6, 20, 14],
            [4, 6, 3, 10, 7],
            [2, 4, 2, 7, 5],
            [2, 3, 2, 5, 4],
            [1, 2, 1, 4, 3],

        ];



        $hungarian  = new Hungarian($originalArray);
        $allocation = $hungarian->solveMin();
        dd($allocation);

        exit();

    }
}

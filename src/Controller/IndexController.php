<?php

namespace App\Controller;

use App\Entity\Developers;
use App\Repository\DevelopersRepository;
use App\Service\JobServices;
use App\Service\Providers\ProviderAll;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\JobEntity as EntityJobs;


class IndexController extends AbstractController
{



    /**
     * @Route("/", name="Index")
     */
    public function index(DevelopersRepository $developersRepository)
    {

//        $strJsonFileContents = file_get_contents("/var/www/html/symfony/blog/src/Controller/index.json");
//        $_getir = json_decode($strJsonFileContents, true);
//        return new JsonResponse($_getir);

//        $developers = $developersRepository->findAll(\PDO::FETCH_ASSOC);
//        foreach ($developers as $developer) {
//            print_r($developer);
//            break;
//        }

//        $jobs = new JobServices();
//        $jobs->jobs = $_getir;
//        $jobs->developers = $devs;
//        $e = $jobs->atamaYap();

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

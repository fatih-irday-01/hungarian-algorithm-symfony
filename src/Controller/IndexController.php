<?php

namespace App\Controller;

use App\Entity\DevelopersJobs;
use App\Repository\DevelopersJobsRepository;
use App\Repository\DevelopersRepository;
use App\Repository\JobsRepository;

use App\Service\JobToDeveloperServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{


    /**
     * @Route("/", name="Index")
     */
    public function index(
        DevelopersRepository $developersRepository,
        DevelopersJobsRepository $developersJobsRepository,
        JobsRepository $jobsRepository)
    {

        // yasal calisma saati oldugundan yasa degisene kadar sabittir.
        // TODO : bu veriyi ENV'den almati unutma
        $haftalikCalismaSaati = 45;


        /* hazirlanmis verileri getir */
        $developers = $developersRepository->findAll();
        $devToJobs   = $developersJobsRepository->findBy([],['sequence' => 'asc']);
        $jobs       = $jobsRepository->findAll();


        /* developeralari islerle esitleyecek sekilde hazirla */
        $developerMaps = [];
        foreach ($developers as $developer)
        {

            $key = $developer->getId();
            $add = [
                'developer' => $developer,
                'jobs' => [],
            ];
            $developerMaps[$key] = $add;

        }


        /* isleri id'lerine gore sirala, islerle yazilimcilari esitlerken kullanacaksin */
        $jobMaps = [];
        foreach ($jobs as $job)
        {
            $key = $job->getId();
            $jobMaps[$key] = $job;
        }

        /* iler ve yazilimcilar islenebilir sekilde esitle */
        foreach ($devToJobs as $devToJob)
        {
            $getJob     = $jobMaps[$devToJob->getJobid()];

            $developerMaps[$devToJob->getDeveloperid()]['jobs'][$devToJob->getSequence()] = [
                'name' => $getJob->getName(),
                'duration' => $getJob->getDuration(),
                'runTime' => $devToJob->getRunTimer(),
                'level' => $getJob->getLevel(),
            ];
        }




        /* haftalik plani cikart, frontend'e hazirla*/
        $haftalikRapor = [];

        foreach ($developerMaps as $developerMap)
        {

            $key = $developerMap['developer']->getId(); // yazilimcinin id'si

            $plan = []; // her yazlimci icin haftalik plan
            $totalRunTime = 0; // yazilmcinin toplam calisma saati
            $hafta = 1; // calisma yapilacak hafta numarasi | kacinci hafta ?


            /* yazilimci icin haftalik plan */
            foreach ($developerMaps[$key]['jobs'] as $job)
            {
                /* Eklenecek veri */
                $runTime = $job['runTime']; // is icin calisma saati
                $job['developerTotalRunTime'] = $runTime; // isin toplam yapilma suresi

                /* bu hafta icin yer var mi ? */
                if( $totalRunTime >= $haftalikCalismaSaati ) {
                    $hafta += 1; // sonra ki haftaya gec
                    $totalRunTime = 0; // bir sonra ki hafta toplam calisma saati
                }

                $endRunTime   = $totalRunTime; // is eklenmeden onceki calisma saati
                $totalRunTime += $runTime; // bu isin calisma saatini tolma ekle


                /*
                 *  is eklenince haftalik calisma saatiasilmis olabilir
                 *  yazilimci sonrakş hafta bu ise devam etmek zorunda kalabilir
                 *  bunun icin ayni isin sonraki haftada da gorulmesi gerekecek
                 */
                if($totalRunTime>$haftalikCalismaSaati) {

                    $job['runTime'] = $haftalikCalismaSaati-$endRunTime;  // sonraki hafta bu ise kac saat ayiracak
                    $plan[$hafta][] = $job; // isi plana ekle

                    $totalRunTime   = $runTime - ($haftalikCalismaSaati-$endRunTime); // bir sonra ki hafta toplam calisma saati
                    $job['runTime'] = $totalRunTime; // sonraki hafta bu ise kac saat ayiracak

                    $hafta += 1; // sonra ki haftaya gec
                    $plan[$hafta][] = $job; // isi plana ekle
                }else{
                    $plan[$hafta][] = $job; // isi plana ekle
                }



            }


            /// cikti kalibi olurstur.
            $haftalikRapor[$key] = [
                'developer' => [
                    'name'  => $developerMap['developer']->getName(),
                    'ability' => $developerMap['developer']->getAbility()
                ],
                'plan' => $plan
            ];


        }

//        dd($haftalikRapor);
        return $this->render('Index/index.html.twig', [
            'raporlar' => $haftalikRapor
        ]);


    }




    /**
     * @Route("/calculation", name="calculation")
     */
    public function calculation()
    {

        return $this->render('Index/calculation.html.twig');

    }

    /**
     * @Route("/make-calculation", name="make_calculation")
     */
    public function make_calculation(DevelopersRepository $developersRepository, JobsRepository $jobsRepository)
    {

        $developers = $developersRepository->findAll();
        $jobs       = $jobsRepository->findAll();


        $jobs = new JobToDeveloperServices($developers,$jobs);
        $result = $jobs->jobsToDeveloper();

        $manager = $this->getDoctrine()->getManager();
        $q = $manager->createQuery('delete from  App\Entity\DevelopersJobs');
        $q->execute();

        foreach ($result as $item)
        {
            $jobs = new DevelopersJobs();
            $jobs->setDeveloperid($item['developerId'])
                ->setJobid($item['jobId'])
                ->setRunTimer($item['runTimer'])
                ->setSequence($item['sequence']);
            $manager->persist($jobs);
        }
        $manager->flush();

        return new JsonResponse($result);

    }



    /**
     * @Route("/make-calculation-job/{id}", name="make_calculation_job")
     */
    public function make_calculation_job(DevelopersJobs $developersJobs, JobsRepository $jobsRepository)
    {

        $manager = $this->getDoctrine()->getManager();

        $sql = "SELECT 
                sum(jobs.run_timer) as timer, count(jobs.id) as sequence, dev.name as developerName, job.name as jobName
                FROM developers_jobs as jobs
                inner join developers as dev on dev.id = jobs.developer_id
                inner join jobs as job on job.id = :jobId
                where jobs.developer_id = :devId
                and jobs.sequence <= :sequence
                and jobs.id <= :id";



        $runTime = $manager->getConnection()->prepare($sql);

        $runTime->bindValue('jobId',$developersJobs->getJobid());
        $runTime->bindValue('devId',$developersJobs->getDeveloperid());
        $runTime->bindValue('sequence',$developersJobs->getSequence());
        $runTime->bindValue('id',$developersJobs->getId());
        $runTime->execute();
        $result = $runTime->fetch();


        $jobs = $jobsRepository->findBy([], ['name'=>'asc']);

        $data = [
            'jobs' => $jobs,
            'jobName' => $result['jobName'],
            'developerName' => $result['developerName'],
            'DeveloperRunTime' => $developersJobs->getRunTimer(),
            'sequence' => $result['sequence'],
            'startTime' => $result['timer'] - $developersJobs->getRunTimer(),
            'endTime' => $result['timer'],
        ];


        return $this->render('Index/make_calculation_job.html.twig', $data);
    }



    /**
     * @Route("/job-status", name="job_status")
     */
    public function job_status(JobsRepository $jobsRepository)
    {
        $jobs = $jobsRepository->findBy([], ['name'=>'asc']);

        return $this->render('Index/job_status.html.twig', [
            'jobs' => $jobs
        ]);

    }


}

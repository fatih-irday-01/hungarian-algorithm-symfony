<?php


namespace App\Service;

use Hungarian\Hungarian;


class JobServices
{


    public function __construct($developersRepository, $jobsRepository)
    {
        $this->developers = $developersRepository->findAll();
        $this->jobs       = $jobsRepository->findAll();

        $this->treeJobs = array_chunk($this->jobs, count((array)$this->developers));
        $this->developerGroup = [];
        $this->jobsGroup = [];
    }


    public function createMatris()//: array
    {
//
//        $matrix = [
//            [1, 2, 3, 0, 1],
//            [0, 3, 12, 1, 1],
//            [3, 0, 1, 13, 1],
//            [3, 1, 1, 12, 0],
//            [3, 1, 1, 12, 0],
//        ];
//
//        $hungarian  = new Hungarian($matrix);
//        $allocation = $hungarian->solveMin();
//        print_r($allocation);




        echo '<pre>';


        foreach ($this->treeJobs as $treeJobs) {
            $addMatrix = [];
            $this->oneMatrix($treeJobs);
        }




    }

    private function oneMatrix($treeJobs)
    {
        $row = 0;
        foreach ($this->developers as $k => $developer) {

            $devId = $developer->getId(); // islem yapilan dev id
            $this->developerGroup[$row] = $devId; // bu dev matrix'in kacinci sarasinda ?


            $row2 = 0;
            foreach ($treeJobs as $treeJob) { // job grubunu her developer icin matrix'e ekle

                $jobId = $treeJob->getId();
                $this->jobsGroup[$row][$row2] = $jobId; // job'un matrixteki yeri

                $e = $this->developerToJob($developer, $treeJob);

                $row2++;
            }

            echo '<br />';

            $row++;
        }
        echo '------------0---------------';
        echo '<br />';
    }







    private function developerToJob($developer, $treeJob)
    {


        echo ($treeJob->getDuration() * $treeJob->getLevel() / $developer->getA);
        dd();


    }



}
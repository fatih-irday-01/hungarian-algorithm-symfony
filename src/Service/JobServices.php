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


    public function createMatris(): array
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




        $allMatrix = [];
        $matrixDesc = 0;
        foreach ($this->treeJobs as $treeJobs) {
//        foreach ([end($this->treeJobs)] as $treeJobs) {
            $addMatrix = $this->oneMatrix($matrixDgit esc, $treeJobs);
            $allMatrix[] = $addMatrix;
            $matrixDesc++;
        }
        return $allMatrix;





    }

    private function oneMatrix($matrixDesc, $treeJobs)
    {
        $row = 0; // jobs sirasi
        $matrix = []; // matrix'ler
        $developerSize = count((array)$this->developers); // yazilimci sayisi

        foreach ($this->developers as $k => $developer) {

            $devId = $developer->getId(); // islem yapilan dev id
            $this->developerGroup[$matrixDesc][$row] = $devId; // bu dev matrix'in kacinci sarasinda ?



            if($developerSize>count($treeJobs)){
                $treeJobs[] = range(999,999+$developerSize);
            }

            $row2 = 0;
            $rowData = []; // bir yazilimci icin x ekseni
            foreach ($treeJobs as $treeJob) { // job grubunu her developer icin matrix'e ekle


                if (is_object($treeJob)){
                    $jobId = $treeJob->getId();
                    $this->jobsGroup[$matrixDesc][$row][$row2] = $jobId; // job'un matrixteki yeri
                    // yazilimcinin is icin hesaplanan verimi
                    $yield = $this->developerYield($developer, $treeJob);
                    $rowData[] = $yield;
                }else{
                    $rowData[] = 99999;
                }



//                $rowData[] = [
//                    'dev' => $developer->getAbility(),
//                    'level' => $treeJob->getLevel(),
//                    'getDuration' => $treeJob->getDuration(),
//                    'yield' => $yield,
//                ];


                $row2++;
            }
            $row++;
            $matrix[] = $rowData;
        }

        return $matrix;
    }

    private function developerYield($developer, $treeJob)
    {
        // yazilimcinin is icin hesaplanan verimi
        $yield = $treeJob->getDuration() * $treeJob->getLevel() / $developer->getAbility();
        return (integer) round($yield);

    }

    public function jobsToDeveloper()
    {
        echo '<pre>';
        $e = $this->createMatris();
        foreach ($e as $k=>$createMatris) {
            $hungarian  = new Hungarian($createMatris);
            $allocation = $hungarian->solveMin();


            // e sizari k
//            print_r($k);

            foreach ($allocation as $dev => $job) {
//                print_r($dev);
                $developer = $this->developerGroup[$k][$dev];
                $jobs      = !empty($this->jobsGroup[$k][$dev][$job]) ? $this->jobsGroup[$k][$dev][$job] : null;
                echo $developer;
                echo ' => ';
                echo $jobs;
                echo '<br >';
            }


        }


    }

}
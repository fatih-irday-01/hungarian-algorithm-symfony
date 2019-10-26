<?php


namespace App\Service;

use Hungarian\Hungarian;


class JobToDeveloperServices
{

    private $developerGroup = [];
    private $jobsGroup = [];

    public function __construct($developers, $jobs)
    {

        $this->developers = $developers;
        $this->jobs       = $jobs;

        $this->treeJobs = array_chunk($this->jobs, count((array)$this->developers));

    }

    public function createMatris(): array
    {

        $allMatrix = [];
        $matrixDesc = 0;
        foreach ($this->treeJobs as $treeJobs) {
            $addMatrix = $this->oneMatrix($matrixDesc, $treeJobs);
            $allMatrix[] = $addMatrix;
            $matrixDesc++;
        }
        return $allMatrix;

    }

    private function oneMatrix($matrixDesc, $treeJobs): array
    {
        $row = 0; // jobs sirasi
        $matrix = []; // matrix'ler
        $developerSize = count((array)$this->developers); // yazilimci sayisi

        foreach ($this->developers as $k => $developer) {

            $devId = $developer->getId(); // islem yapilan dev id
            $this->developerGroup[$matrixDesc][$row] = $developer; // bu dev matrix'in kacinci sarasinda ?

            // yazilimci ve is sayisi esit deilse sanal is olustur.
            if($developerSize>count($treeJobs)){
                $treeJobs[] = range(999,999+$developerSize);
            }

            $row2 = 0;
            $rowData = []; // bir yazilimci icin x ekseni
            foreach ($treeJobs as $treeJob) { // job grubunu her developer icin matrix'e ekle


                if (is_object($treeJob)){ // gercek ismi
                    $jobId = $treeJob->getId();
                    $this->jobsGroup[$matrixDesc][$row][$row2] = $treeJob; // job'un matrixteki yeri
                    // yazilimcinin is icin hesaplanan verimi
                    $yield = $this->developerYield($developer, $treeJob);
                    $rowData[] = $yield;
                }else{ // sanal is ise
                    $rowData[] = 99999;
                }

                $row2++;
            }
            $row++;
            $matrix[] = $rowData;
        }

        return $matrix;
    }

    private function developerYield($developer, $treeJob): int
    {
        // yazilimcinin is icin hesaplanan verimi
        $yield = ($treeJob->getDuration() * $treeJob->getLevel()) / $developer->getAbility();
        return (integer) round($yield);

    }

    public function jobsToDeveloper(): array
    {
        $_return = [];
        $e = $this->createMatris();
        foreach ($e as $k=>$createMatris) {
            $hungarian  = new Hungarian($createMatris);
            $allocation = $hungarian->solveMin();

            foreach ($allocation as $dev => $job) {
                $developer = $this->developerGroup[$k][$dev];
                $jobs      = !empty($this->jobsGroup[$k][$dev][$job]) ? $this->jobsGroup[$k][$dev][$job] : null;

                if(is_object($developer) && is_object($jobs)){

                    $_return[] = [
                        'sequence' => $k,
                        'developerId' => $developer->getId(),
                        'jobId' => $jobs->getId(),
                        'runTimer' => $this->developerYield($developer, $jobs),
                    ];

                }

            }


        }

        return $_return;

    }


}
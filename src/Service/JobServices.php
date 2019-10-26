<?php


namespace App\Service;


class JobServices
{


    public $developerRunTime = 45;
    public $developers = [];
    public $jobs       = [];


    public function atamaYap()
    {

        $jobList = [];
        $devList = [];



        foreach ($this->developers as $developer) {

            if (empty($devList[$developer->getAbility()])) {
                $devList[$developer->getAbility()] = [];
            }
            $devList[$developer->getAbility()][] = [
                'id' => $developer->getId(),
                'runTime' => 0
            ];
        }


        foreach ($this->jobs as $job) {


            // is ile ayni seviyede yazilimci, var mi ?
            if(!empty($devList[$job->getLevel()])){

                foreach ($devList[$job->getLevel()] as $key=>$item) {
                    if($item['runTime'] < $this->developerRunTime){
                        $devList[$job->getLevel()][$key]['runTime'] += $job->getDuration();
                        $jobList[$job->getId()] = $item['id'];
                        break;
                    }
                }


            }else{
                dd($devList[$job->getLevel()]);
            }


        }
        print_r($jobList);
        print_r($devList);

    }


}
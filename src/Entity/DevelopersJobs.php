<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevelopersJobsRepository")
 */
class DevelopersJobs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $developer_id;


    /**
     * @ORM\Column(type="integer")
     */
    private $job_id;


    /**
     * @ORM\Column(type="integer")
     */
    private $runTimer;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDeveloperid(): ?int
    {
        return $this->developer_id;
    }

    public function setDeveloperid(int $developer_id): self
    {
        $this->developer_id = $developer_id;

        return $this;
    }


    public function getJobid(): ?int
    {
        return $this->job_id;
    }

    public function setJobid(int $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }


    public function getRunTimer(): ?int
    {
        return $this->runTimer;
    }

    public function setRunTimer(int $runTimer): self
    {
        $this->runTimer = $runTimer;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }


}

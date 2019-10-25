<?php


namespace App\Command;

use App\Entity\Jobs as JobEntity;
use App\Service\Providers\ProviderAll;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ProviderCommand extends Command
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }


    protected function configure()
    {
        $this
            ->setName('app:getProviders')
            ->setDescription('Görevleri cekmek icin kullanilir.')
            ->setHelp('php bin/console app:getProviders');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // TODO : eski veriler ne olacak ?

        $client = new providerAll();
        $getir = $client->getResponse();

        $manager = $this->container->get('doctrine')->getManager();
        foreach ($getir as $item) {
            $jobs = new JobEntity();
            $jobs->setName($item['name'])
                ->setLevel($item['level'])
                ->setDuration($item['duration']);
            $manager->persist($jobs);
        }

        $manager->flush();

        $output->writeln('MESSAGE : islem tamamlandi');

    }

}
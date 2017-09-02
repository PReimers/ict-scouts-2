<?php

namespace AppBundle\Command;

use AppBundle\Service\GoogleUserService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GoogleUserSyncCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('google:user-sync')
            ->setDescription('Synchronize users with Google Apps')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->title('Synchronizing Google Users');

        $googleUserService = $this->getContainer()->get(GoogleUserService::class);
        $googleUserService->getAllUsers($googleUserService->getGoogleService()->getGoogleConfig()['apps_domain']);

        $symfonyStyle->success('Synchronization successful');
    }

}

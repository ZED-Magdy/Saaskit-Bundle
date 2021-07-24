<?php
namespace ZedMagdy\Bundle\SaasKitBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateTenantCommand extends Command
{
    protected static $defaultName = 'saaskit:create-tenant';
    private EntityManagerInterface $em;
    private EventDispatcherInterface $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Tenant name')
            ->addArgument('email', InputArgument::REQUIRED, 'Tenant admin email')
            ->addArgument('password', InputArgument::REQUIRED, 'Tenant admin password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("name: {$input->getArgument('name')}");
        $output->writeln("email: {$input->getArgument('email')}");
        $output->writeln("password: {$input->getArgument('password')}");
        sleep(10);
        return Command::SUCCESS;
    }
}
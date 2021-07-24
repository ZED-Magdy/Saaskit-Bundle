<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Messages;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateTenantHandler implements MessageHandlerInterface
{
    private KernelInterface $kernel;
    private LoggerInterface $logger;

    public function __construct(KernelInterface $kernel, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->logger = $logger;
    }
    public function __invoke(CreateTenant $message)
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput([
            'command' => 'saaskit:create-tenant',
            'name' => $message->getName(),
            'email' => $message->getEmail(),
            'password' => $message->getPassword()
        ]);
        $output = new BufferedOutput();
        try {
            $application->run($input, $output);
            $this->logger->info($output->fetch());
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
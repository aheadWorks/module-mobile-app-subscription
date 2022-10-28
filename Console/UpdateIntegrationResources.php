<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Console;

use Magento\Framework\DataObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Integration\Api\IntegrationServiceInterface;
use Aheadworks\MobileAppSubscription\Model\Service\GeneratorProcess;
use Magento\Integration\Model\AuthorizationService;
use Psr\Log\LoggerInterface;

/**
 * Class Command UpdateIntegrationResources
 */
class UpdateIntegrationResources extends Command
{
    /**
     * @var IntegrationServiceInterface
     */
    private $integrationService;

    /**
     * @var DataObject
     */
    private $tokenResources;

    /**
     * @var AuthorizationService
     */
    private $authorization;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UpdateIntegrationResources constructor.
     *
     * @param IntegrationServiceInterface $integrationService
     * @param DataObject $tokenResources
     * @param AuthorizationService $authorization
     * @param LoggerInterface $logger
     * @param string|null $name
     */
    public function __construct(
        IntegrationServiceInterface $integrationService,
        DataObject $tokenResources,
        AuthorizationService $authorization,
        LoggerInterface $logger,
        string $name = null
    ) {
        $this->integrationService = $integrationService;
        $this->tokenResources = $tokenResources;
        $this->authorization = $authorization;
        $this->logger = $logger;
        parent::__construct($name);
    }

    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('aw-mobile-app-subscription:update-resources');
        $this->setDescription('MobileAppSubscription by Aheadworks: update resources');

        parent::configure();
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $integration = $this->integrationService->findByName(GeneratorProcess::INTEGRATION_NAME);
        if (!$integration->getId()) {
            $output->writeln('<error>Integration not found!</error>');
            return;
        }
        try {
            $this->authorization->grantPermissions(
                $integration->getId(),
                $this->tokenResources->getData('resources')
            );
            $output->writeln('<info>Update Integration Resources was completed successfully.</info>');
        } catch (\Exception $ex) {
            $this->logger->error($ex);
            $output->writeln('<error>Exception! Something went wrong!</error>');
        }
    }
}

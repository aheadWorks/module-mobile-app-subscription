<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Console\Integration;

use Aheadworks\MobileAppSubscription\Model\Service\GeneratorProcess;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface as Logger;
use Aheadworks\MobileAppSubscription\Api\TokenGeneratorInterface;
use Aheadworks\MobileAppSubscription\Api\TokenGeneratorInterfaceFactory;

/**
 * Class Delete integration
 */
class Delete extends Command
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var TokenGeneratorInterfaceFactory
     */
    private TokenGeneratorInterfaceFactory $tokenGeneratorFactory;

    /**
     * Delete constructor.
     *
     * @param Logger $logger
     * @param TokenGeneratorInterfaceFactory $tokenGeneratorFactory
     */
    public function __construct(
        Logger $logger,
        TokenGeneratorInterfaceFactory $tokenGeneratorFactory
    ) {
        $this->logger = $logger;
        $this->tokenGeneratorFactory = $tokenGeneratorFactory;
        parent::__construct();
    }

    /**
     * Configuration for the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName(
                'aw-mobile-app-subscription:delete-integration'
            )->setDescription(
                'Remove launched integration'
                . ' and created key for mobile application'
            )
        ;

        parent::configure();
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            /** @var TokenGeneratorInterface $tokenGenerator */
            $tokenGenerator = $this->tokenGeneratorFactory->create();
            $tokenGenerator->deleteMobileKey(
                GeneratorProcess::INTEGRATION_NAME
            );
            return Cli::RETURN_SUCCESS;
        } catch (\Exception $exception) {
            $this->logger->alert(
                __(
                    "aw-mobile-app-subscription:delete-integration error: %1",
                    $exception->getMessage()
                )
            );
            return Cli::RETURN_FAILURE;
        }
    }
}

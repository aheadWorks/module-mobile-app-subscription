<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Console\Integration;

use Aheadworks\MobileAppSubscription\Model\Service\GeneratorProcess;
use Aheadworks\MobileAppSubscription\Model\Service\GeneratorProcessFactory;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Launch the integration creation
 */
class Launch extends Command
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var GeneratorProcessFactory
     */
    private GeneratorProcessFactory $generatorProcessFactory;

    /**
     * Launch constructor.
     *
     * @param Logger $logger
     * @param GeneratorProcessFactory $generatorProcessFactory
     */
    public function __construct(
        Logger $logger,
        GeneratorProcessFactory $generatorProcessFactory
    ) {
        $this->logger = $logger;
        $this->generatorProcessFactory = $generatorProcessFactory;
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
                'aw-mobile-app-subscription:launch-integration'
            )->setDescription(
                'Manually launch the integration creation'
                . ' and creation of the key for mobile application'
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
            /** @var GeneratorProcess $generatorProcess */
            $generatorProcess = $this->generatorProcessFactory->create();
            $generatorProcess->launch();
            return Cli::RETURN_SUCCESS;
        } catch (\Exception $exception) {
            $this->logger->alert(
                __(
                    "aw-mobile-app-subscription:launch-integration error: %1",
                    $exception->getMessage()
                )
            );
            return Cli::RETURN_FAILURE;
        }
    }
}

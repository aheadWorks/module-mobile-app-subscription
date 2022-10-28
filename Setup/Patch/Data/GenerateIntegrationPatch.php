<?php
namespace Aheadworks\MobileAppSubscription\Setup\Patch\Data;

use Aheadworks\MobileAppSubscription\Model\Service\GeneratorProcess;
use Aheadworks\MobileAppSubscription\Model\Service\TokenGenerator;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Generate an integration
 */
class GenerateIntegrationPatch implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var TokenGenerator
     */
    protected $tokenGenerator;

    /**
     * @var GeneratorProcess
     */
    protected $generatorProcess;

    /**
     * GenerateIntegrationPatch constructor.
     *
     * @param TokenGenerator $tokenGenerator
     * @param GeneratorProcess $generatorProcess
     */
    public function __construct(
        TokenGenerator $tokenGenerator,
        GeneratorProcess $generatorProcess
    ) {
        $this->tokenGenerator = $tokenGenerator;
        $this->generatorProcess = $generatorProcess;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Run code inside patch
     *
     * @return GenerateIntegrationPatch
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function apply(): GenerateIntegrationPatch
    {
        $this->generatorProcess->launch();
        return $this;
    }

    /**
     * Rollback all changes, done by this patch
     *
     * @return void
     * @throws \Magento\Framework\Exception\IntegrationException
     */
    public function revert(): void
    {
        $this->tokenGenerator->deleteMobileKey(GeneratorProcess::INTEGRATION_NAME);
    }
}

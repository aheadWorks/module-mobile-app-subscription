<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api;

/**
 * Interface TokenGeneratorInterface
 * @api
 */
interface TokenGeneratorInterface
{
    /**
     * Generate mobile key
     *
     * @param string $integrationName
     * @param string $supportEmail
     * @param string $customerEmail
     * @param string $endpoint
     * @param string $customerName
     * @param int $storeId
     * @param array $accessResources
     * @return bool
     */
    public function generateMobileKey(
        string $integrationName,
        string $supportEmail,
        string $customerEmail,
        string $endpoint,
        string $customerName,
        int $storeId,
        array $accessResources = []
    ): bool;

    /**
     * Delete mobile key
     *
     * @param string $integrationName
     * @return bool
     * @throws \Magento\Framework\Exception\IntegrationException
     */
    public function deleteMobileKey(string $integrationName): bool;
}

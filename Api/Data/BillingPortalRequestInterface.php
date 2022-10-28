<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api\Data;

/**
 * Interface BillingPortalRequestInterface
 */
interface BillingPortalRequestInterface
{
    /**#@+
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    public const APPLICATION_KEY = 'application_key';
    public const LIVE_TOKEN = 'live_token';
    public const INTEGRATION_DATA = 'integration_data';
    /**#@-*/

    /**
     * Set mobile key
     *
     * @param string $value
     * @return $this
     */
    public function setApplicationKey(string $value): BillingPortalRequestInterface;

    /**
     * Get mobile key
     *
     * @return string|null
     */
    public function getApplicationKey(): ?string;

    /**
     * Set live token
     *
     * @param string $value
     * @return $this
     */
    public function setLiveToken(string $value): BillingPortalRequestInterface;

    /**
     * Get live token
     *
     * @return string|null
     */
    public function getLiveToken(): ?string;

    /**
     * Set Integration
     *
     * @param array $integrationData
     * @return $this
     */
    public function setIntegrationData(array $integrationData): BillingPortalRequestInterface;

    /**
     * Get Integration
     *
     * @return array|null
     */
    public function getIntegrationData(): ?array;
}

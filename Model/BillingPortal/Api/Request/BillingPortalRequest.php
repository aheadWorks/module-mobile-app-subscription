<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\BillingPortal\Api\Request;

use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalRequestInterface;
use Magento\Framework\DataObject;

/**
 * Class BillingPortalRequest
 */
class BillingPortalRequest extends DataObject implements BillingPortalRequestInterface
{
    /**
     * Set mobile key
     *
     * @param string $value
     * @return $this
     */
    public function setApplicationKey(string $value): BillingPortalRequestInterface
    {
        return $this->setData(self::APPLICATION_KEY, $value);
    }

    /**
     * Get mobile key
     *
     * @return string|null
     */
    public function getApplicationKey(): ?string
    {
        return $this->getData(self::APPLICATION_KEY);
    }

    /**
     * Set Integration data
     *
     * @param array $integrationData
     * @return $this
     */
    public function setIntegrationData(array $integrationData): BillingPortalRequestInterface
    {
        return $this->setData(self::INTEGRATION_DATA, $integrationData);
    }

    /**
     * Get Integration data
     *
     * @return array|null
     */
    public function getIntegrationData(): ?array
    {
        return $this->getData(self::INTEGRATION_DATA);
    }

    /**
     * Set live token
     *
     * @param string $value
     * @return $this
     */
    public function setLiveToken(string $value): BillingPortalRequestInterface
    {
        return $this->setData(self::LIVE_TOKEN, $value);
    }

    /**
     * Get live token
     *
     * @return string|null
     */
    public function getLiveToken(): ?string
    {
        return $this->getData(self::LIVE_TOKEN);
    }
}

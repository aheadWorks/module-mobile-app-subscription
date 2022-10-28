<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model;

use Aheadworks\MobileAppSubscription\Api\Data\SubscriptionInterface;
use Magento\Framework\FlagManager;
use Aheadworks\MobileAppConnector\Model\Config as ConnectorConfig;
use Aheadworks\MobileAppSubscription\Model\Config as SubscriptionConfig;

/**
 * Class Subscription
 */
class Subscription implements SubscriptionInterface
{
    /**
     * @var FlagManager
     */
    private $flagManager;

    /**
     * @var ConnectorConfig
     */
    private $connectorConfig;

    /**
     * @var SubscriptionConfig
     */
    private $subscriptionConfig;

    /**
     * Subscription constructor.
     *
     * @param FlagManager $flagManager
     * @param ConnectorConfig $connectorConfig
     * @param SubscriptionConfig $subscriptionConfig
     */
    public function __construct(
        FlagManager $flagManager,
        ConnectorConfig $connectorConfig,
        SubscriptionConfig $subscriptionConfig
    ) {
        $this->flagManager = $flagManager;
        $this->connectorConfig = $connectorConfig;
        $this->subscriptionConfig = $subscriptionConfig;
    }

    /**
     * Set mobile key
     *
     * @param string|null $value
     * @return $this
     */
    public function setMobileKey(?string $value): SubscriptionInterface
    {
        $this->flagManager->saveFlag(self::MOBILE_KEY, $value);
        return $this;
    }

    /**
     * Get mobile key
     *
     * @return string|null
     */
    public function getMobileKey(): ?string
    {
        return $this->flagManager->getFlagData(self::MOBILE_KEY);
    }

    /**
     * Get live token
     *
     * @return string|null
     */
    public function getLiveToken(): ?string
    {
        return $this->subscriptionConfig->getLiveTokenValue(true);
    }

    /**
     * Get active mode
     *
     * @return string
     */
    public function getActiveMode(): string
    {
        return $this->connectorConfig->isProductionModeEnabled() ? self::PRODUCTION_MODE : self::TRIAL_MODE;
    }

    /**
     * Set status
     *
     * @param int $value
     * @return $this
     */
    public function setStatus(int $value): SubscriptionInterface
    {
        $this->flagManager->saveFlag(self::SUBSCRIPTION_STATUS, $value);
        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->flagManager->getFlagData(self::SUBSCRIPTION_STATUS);
    }
}

<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\BillingPortal\Api\Response;

use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalResponseInterface;
use Aheadworks\MobileAppSubscription\Api\Data\SubscriptionInterface;
use Magento\Framework\DataObject;

/**
 * Class BillingPortalResponse
 */
class BillingPortalResponse extends DataObject implements BillingPortalResponseInterface
{
    /**
     * @var array
     */
    private $activeSubscriptionStatuses;

    /**
     * BillingPortalResponse constructor.
     *
     * @param array $activeSubscriptionStatuses
     * @param array $data
     */
    public function __construct(array $activeSubscriptionStatuses = [], array $data = [])
    {
        $this->activeSubscriptionStatuses = $activeSubscriptionStatuses;
        parent::__construct($data);
    }

    /**
     * Set mobile key
     *
     * @param string|null $value
     * @return $this
     */
    public function setApplicationKey(?string $value): BillingPortalResponseInterface
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
     * Set trial status
     *
     * @param int|null $value
     * @return $this
     */
    public function setTrialStatus(?int $value): BillingPortalResponseInterface
    {
        return $this->setData(self::TRIAL_STATUS, $value);
    }

    /**
     * Get trial status
     *
     * @return int|null
     */
    public function getTrialStatus(): ?int
    {
        return $this->getData(self::TRIAL_STATUS);
    }

    /**
     * Set production status
     *
     * @param int|null $value
     * @return $this
     */
    public function setLiveStatus(?int $value): BillingPortalResponseInterface
    {
        return $this->setData(self::LIVE_STATUS, $value);
    }

    /**
     * Get production status
     *
     * @return int|null
     */
    public function getLiveStatus(): ?int
    {
        return $this->getData(self::LIVE_STATUS);
    }

    /**
     * Get subscription status
     *
     * @return int
     */
    public function getFinalSubscriptionStatus(): int
    {
        $result = SubscriptionInterface::STATUS_DISABLED;
        $trialStatus = $this->getTrialStatus();
        $liveStatus = $this->getLiveStatus();
        if (in_array($trialStatus, $this->activeSubscriptionStatuses['trial']) ||
            in_array($liveStatus, $this->activeSubscriptionStatuses['live'])) {
            $result = SubscriptionInterface::STATUS_ENABLED;
        }
        return $result;
    }
}

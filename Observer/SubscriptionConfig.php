<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Aheadworks\MobileAppSubscription\Api\SubscriptionManagerInterface;

/**
 * Class SubscriptionConfig
 */
class SubscriptionConfig implements ObserverInterface
{
    /**
     * @var SubscriptionManagerInterface
     */
    private $subscriptionManager;

    /**
     * Config constructor.
     *
     * @param SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(SubscriptionManagerInterface $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * Running a request of subscription from billing portal when system settings will save
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $this->subscriptionManager->updateSubscriptionDataByApi();
    }
}

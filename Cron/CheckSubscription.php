<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Cron;

use Aheadworks\MobileAppSubscription\Api\SubscriptionManagerInterface;

/**
 * Class Check Subscription by cron once a day
 */
class CheckSubscription
{
    /**
     * @var SubscriptionManagerInterface
     */
    private $subscriptionManager;

    /**
     * CheckSubscription constructor.
     *
     * @param SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(SubscriptionManagerInterface $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * Execute to check subscription
     *
     * @return void
     */
    public function execute()
    {
        $this->subscriptionManager->updateSubscriptionDataByApi();
    }
}

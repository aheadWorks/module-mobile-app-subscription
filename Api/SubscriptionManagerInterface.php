<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api;

/**
 * Interface SubscriptionManagerInterface
 * @api
 */
interface SubscriptionManagerInterface
{
    /**
     * Is subscription active
     *
     * @return bool
     */
    public function isSubscriptionActive(): bool;

    /**
     * Is production mode enabled
     *
     * @return bool
     */
    public function isProductionModeEnabled(): bool;

    /**
     * Update subscription data by Api
     *
     * @return void
     */
    public function updateSubscriptionDataByApi(): void;
}

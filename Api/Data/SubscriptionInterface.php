<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api\Data;

/**
 * Interface SubscriptionInterface
 * @api
 */
interface SubscriptionInterface
{
    /**
     * Flag manager constants
     */
    public const MOBILE_KEY = 'aw_mas_mobile_key';
    public const SUBSCRIPTION_STATUS = 'aw_mas_subscription_status';

    /**
     * Active mode values constants
     */
    public const PRODUCTION_MODE = 'production';
    public const TRIAL_MODE = 'trial';

    /**
     * Subscription status values constants
     */
    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;
    public const STATUS_FAILED = 2;

    /**
     * Set mobile key
     *
     * @param string|null $value
     * @return $this
     */
    public function setMobileKey(?string $value): SubscriptionInterface;

    /**
     * Get mobile key
     *
     * @return string|null
     */
    public function getMobileKey(): ?string;

    /**
     * Get live token
     *
     * @return string|null
     */
    public function getLiveToken(): ?string;

    /**
     * Get active mode
     *
     * @return string
     */
    public function getActiveMode(): string;

    /**
     * Set status
     *
     * @param int $value
     * @return $this
     */
    public function setStatus(int $value): SubscriptionInterface;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;
}

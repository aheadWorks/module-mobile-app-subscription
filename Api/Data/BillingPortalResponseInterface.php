<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api\Data;

/**
 * Interface BillingPortalResponseInterface
 */
interface BillingPortalResponseInterface
{
    /**
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    public const APPLICATION_KEY = 'application_key';
    public const TRIAL_STATUS = 'trial_status';
    public const LIVE_STATUS = 'live_status';

    /**
     * Constants for trial mode statuses
     */
    public const TRIAL_STATUS_ACTIVE = 1;
    public const TRIAL_STATUS_EXPIRED = 2;

    /**
     * User does not have a subscription
     */
    public const LIVE_STATUS_NOT_SUBSCRIBED = 1;

    /**
     * Subscription exists and is active
     */
    public const LIVE_STATUS_ACTIVE = 2;

    /**
     * Subscription is canceled
     */
    public const LIVE_STATUS_CANCELLED = 3;

    /**
     * Subscription is paused
     */
    public const LIVE_STATUS_PAUSED = 4;

    /**
     * Trial period of the subscription, between  the moment of subscription
     * creation and the moment of the first scheduled payout
     */
    public const LIVE_STATUS_TRIAL = 5;

    /**
     * Set mobile key
     *
     * @param string|null $value
     * @return $this
     */
    public function setApplicationKey(?string $value): BillingPortalResponseInterface;

    /**
     * Get mobile key
     *
     * @return string|null
     */
    public function getApplicationKey(): ?string;

    /**
     * Set trial status
     *
     * @param int|null $value
     * @return $this
     */
    public function setTrialStatus(?int $value): BillingPortalResponseInterface;

    /**
     * Get trial status
     *
     * @return int|null
     */
    public function getTrialStatus(): ?int;

    /**
     * Set live status
     *
     * @param int|null $value
     * @return $this
     */
    public function setLiveStatus(?int $value): BillingPortalResponseInterface;

    /**
     * Get live status
     *
     * @return int|null
     */
    public function getLiveStatus(): ?int;

    /**
     * Get final subscription status
     *
     * @return int
     */
    public function getFinalSubscriptionStatus(): int;
}

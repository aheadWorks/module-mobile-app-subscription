<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\System\Message;

use Aheadworks\MobileAppSubscription\Api\Data\SubscriptionInterface;
use Magento\Framework\Notification\MessageInterface;

/**
 * Represents notification about failed subscription.
 */
class NotificationAboutFailedSubscription implements MessageInterface
{
    /**
     * @var SubscriptionInterface
     */
    private $subscription;

    /**
     * NotificationAboutFailedSubscription constructor.
     *
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Retrieve unique message identity
     *
     * @return string
     */
    public function getIdentity(): string
    {
        return hash('sha256', 'AW_MAS_NOTIFICATION');
    }

    /**
     * Check whether
     *
     * @return bool
     */
    public function isDisplayed(): bool
    {
        return $this->subscription->getStatus() === SubscriptionInterface::STATUS_FAILED;
    }

    /**
     * Retrieve message text
     *
     * @return string
     */
    public function getText(): string
    {
        $messageDetails = '';
        $messageDetails .= __('Failed to synchronize subscription data to the Aheadworks service. ');
        $messageDetails .= __('A sync retry will start automatically.');

        return $messageDetails;
    }

    /**
     * Retrieve message severity
     *
     * @return int
     */
    public function getSeverity(): int
    {
        return self::SEVERITY_MAJOR;
    }
}

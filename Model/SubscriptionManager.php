<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model;

use Aheadworks\MobileAppSubscription\Model\BillingPortal\Api\RequestBuilder;
use Aheadworks\MobileAppSubscription\Api\SubscriptionManagerInterface;
use Aheadworks\MobileAppSubscription\Api\Data\SubscriptionInterface;
use Aheadworks\MobileAppSubscription\Model\BillingPortal\BillingPortalApiManagement;
use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Subscription Manager
 */
class SubscriptionManager implements SubscriptionManagerInterface
{
    /**
     * @var SubscriptionInterface
     */
    private $subscription;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var BillingPortalApiManagement
     */
    private $billingPortalApiManagement;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SubscriptionManager constructor.
     *
     * @param SubscriptionInterface $subscription
     * @param RequestBuilder $requestBuilder
     * @param BillingPortalApiManagement $billingPortalApiManagement
     * @param LoggerInterface $logger
     */
    public function __construct(
        SubscriptionInterface $subscription,
        RequestBuilder $requestBuilder,
        BillingPortalApiManagement $billingPortalApiManagement,
        LoggerInterface $logger
    ) {
        $this->subscription = $subscription;
        $this->requestBuilder = $requestBuilder;
        $this->billingPortalApiManagement = $billingPortalApiManagement;
        $this->logger = $logger;
    }

    /**
     * Is subscription active
     *
     * @return bool
     */
    public function isSubscriptionActive(): bool
    {
        return $this->subscription->getStatus() === SubscriptionInterface::STATUS_ENABLED;
    }

    /**
     * Is production mode enabled
     *
     * @return bool
     */
    public function isProductionModeEnabled(): bool
    {
        return $this->subscription->getActiveMode() === SubscriptionInterface::PRODUCTION_MODE;
    }

    /**
     * Update subscription data by Api
     *
     * @return void
     */
    public function updateSubscriptionDataByApi(): void
    {
        try {
            $actualStatus = SubscriptionInterface::STATUS_DISABLED;
            if ($this->isProductionModeEnabled()) {
                $liveToken = $this->subscription->getLiveToken();
                if ($liveToken) {
                    $billingPortalRequest = $this->requestBuilder->buildLiveRequest($liveToken);
                    /** @var BillingPortalResponseInterface $billingPortalResponse */
                    $billingPortalResponse = $this->billingPortalApiManagement->getSubscriptionDataByLiveToken(
                        $billingPortalRequest
                    );
                }
            } else {
                $mobileKey = $this->subscription->getMobileKey();
                if ($mobileKey) {
                    $billingPortalRequest = $this->requestBuilder->buildTrialRequest($mobileKey);
                    /** @var BillingPortalResponseInterface $billingPortalResponse */
                    $billingPortalResponse = $this->billingPortalApiManagement->getSubscriptionDataByMobileKey(
                        $billingPortalRequest
                    );
                }
            }
            if (isset($billingPortalResponse)) {
                $actualStatus = $billingPortalResponse->getFinalSubscriptionStatus();
            }

            $this->subscription->setStatus($actualStatus);
        } catch (\Exception $ex) {
            $this->subscription->setStatus(SubscriptionInterface::STATUS_FAILED);

            $this->logger->error(
                'Update subscription data by Api Exception: ' . $ex->getMessage(),
                ['exception' => $ex->getTraceAsString()]
            );
        }
    }
}

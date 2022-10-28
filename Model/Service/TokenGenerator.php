<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\Service;

use Aheadworks\MobileAppSubscription\Api\Data\SubscriptionInterface;
use Aheadworks\MobileAppSubscription\Model\BillingPortal\Api\RequestBuilder;
use Aheadworks\MobileAppSubscription\Model\BillingPortal\BillingPortalApiManagement;
use Aheadworks\MobileAppSubscription\Api\TokenGeneratorInterface;
use Psr\Log\LoggerInterface;
use Aheadworks\MobileAppSubscription\Model\Service\IntegrationManagement;

/**
 * Generate token and get mobile key
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @var BillingPortalApiManagement
     */
    private $billingPortalApiManagement;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var IntegrationManagement
     */
    private $integrationManagement;

    /**
     * @var SubscriptionInterface
     */
    private $subscription;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * TokenGenerator constructor.
     *
     * @param BillingPortalApiManagement $billingPortalApiManagement
     * @param LoggerInterface $logger
     * @param \Aheadworks\MobileAppSubscription\Model\Service\IntegrationManagement $integrationManagement
     * @param SubscriptionInterface $subscription
     * @param RequestBuilder $requestBuilder
     */
    public function __construct(
        BillingPortalApiManagement $billingPortalApiManagement,
        LoggerInterface $logger,
        IntegrationManagement $integrationManagement,
        SubscriptionInterface $subscription,
        RequestBuilder $requestBuilder
    ) {
        $this->billingPortalApiManagement = $billingPortalApiManagement;
        $this->logger = $logger;
        $this->integrationManagement = $integrationManagement;
        $this->subscription = $subscription;
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * Generate mobile key
     *
     * @param string $integrationName
     * @param string $supportEmail
     * @param string $customerEmail
     * @param string $endpoint
     * @param string $customerName
     * @param int $storeId
     * @param array $accessResources
     * @return bool
     */
    public function generateMobileKey(
        string $integrationName,
        string $supportEmail,
        string $customerEmail,
        string $endpoint,
        string $customerName,
        int $storeId,
        array $accessResources = []
    ): bool {
        if (!$this->integrationManagement->isExistIntegration($integrationName)) {
            try {
                $integration = $this->integrationManagement->create(
                    $integrationName,
                    $supportEmail,
                    $customerEmail,
                    $endpoint,
                    $customerName,
                    $storeId,
                    $accessResources
                );

                $billingPortalRequest = $this->requestBuilder->buildGenerateMobileKeyRequest($integration);
                $billingPortalResponse = $this->billingPortalApiManagement->generateMobileKeyByIntegrationData(
                    $billingPortalRequest
                );

                $mobilekey = $billingPortalResponse->getApplicationKey();
                if ($mobilekey) {
                    $this->subscription->setMobileKey($mobilekey);
                }

                return true;
            } catch (\Exception $e) {
                $this->logger->error($e, ['exception' => $e->getTraceAsString()]);
            }
        }
        return false;
    }

    /**
     * Delete mobile key
     *
     * @param string $integrationName
     * @return bool
     * @throws \Magento\Framework\Exception\IntegrationException
     */
    public function deleteMobileKey(string $integrationName): bool
    {
        $this->subscription->setMobileKey(null);
        return $this->integrationManagement->delete($integrationName);
    }
}

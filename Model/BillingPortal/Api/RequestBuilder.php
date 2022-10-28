<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\BillingPortal\Api;

use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalRequestInterfaceFactory;
use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalRequestInterface;
use Aheadworks\MobileAppSubscription\Api\Data\IntegrationInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

/**
 * Class RequestBuilder to prepare requests
 */
class RequestBuilder
{
    /**
     * @var BillingPortalRequestInterfaceFactory
     */
    private $billingPortalRequestFactory;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $dataObjectConverter;

    /**
     * RequestBuilder constructor.
     *
     * @param BillingPortalRequestInterfaceFactory $billingPortalRequestFactory
     * @param ExtensibleDataObjectConverter $dataObjectConverter
     */
    public function __construct(
        BillingPortalRequestInterfaceFactory $billingPortalRequestFactory,
        ExtensibleDataObjectConverter $dataObjectConverter
    ) {
        $this->billingPortalRequestFactory = $billingPortalRequestFactory;
        $this->dataObjectConverter = $dataObjectConverter;
    }

    /**
     * Build request to get subscription info for live mode
     *
     * @param string $liveToken
     * @return BillingPortalRequestInterface
     */
    public function buildLiveRequest(string $liveToken): BillingPortalRequestInterface
    {
        $billingPortalRequest = $this->billingPortalRequestFactory->create();
        return $billingPortalRequest->setLiveToken($liveToken);
    }

    /**
     * Build request to get subscription info for trial mode
     *
     * @param string $mobileKey
     * @return BillingPortalRequestInterface
     */
    public function buildTrialRequest(string $mobileKey): BillingPortalRequestInterface
    {
        $billingPortalRequest = $this->billingPortalRequestFactory->create();
        return $billingPortalRequest->setApplicationKey($mobileKey);
    }

    /**
     * Build request to generate mobile (application) key
     *
     * @param IntegrationInterface $integration
     * @return BillingPortalRequestInterface
     */
    public function buildGenerateMobileKeyRequest(IntegrationInterface $integration): BillingPortalRequestInterface
    {
        $billingPortalRequest = $this->billingPortalRequestFactory->create();
        $integrationData = $this->dataObjectConverter->toFlatArray(
            $integration,
            [],
            IntegrationInterface::class
        );
        return $billingPortalRequest->setIntegrationData($integrationData);
    }
}

<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\BillingPortal;

use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalRequestInterface;
use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalResponseInterface;
use Aheadworks\MobileAppSubscription\Model\Service\Api\Request\Curl;
use Aheadworks\MobileAppSubscription\Api\Data\BillingPortalResponseInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

/**
 * Class BillingPortalApiManagement
 */
class BillingPortalApiManagement
{
    // TODO Url of billing portal to connect by Rest Api
    public const BASE_URL = 'http://mobileapp.do.staging-box.net/portal';
    public const GENERATE_KEY_PATH_URL = '/api/v1/integration/create';
    public const GET_SUBSCRIPTION_TRIAL_PATH_URL = '/api/v1/application/getTrialStatus/';
    public const GET_SUBSCRIPTION_LIVE_PATH_URL = '/api/v1/application/getLiveStatus';

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var BillingPortalResponseInterfaceFactory
     */
    private $billingPortalResponseFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * BillingPortalApiManagement constructor.
     *
     * @param Curl $curl
     * @param BillingPortalResponseInterfaceFactory $billingPortalResponseFactory
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Curl $curl,
        BillingPortalResponseInterfaceFactory $billingPortalResponseFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->curl = $curl;
        $this->billingPortalResponseFactory = $billingPortalResponseFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Generate mobile key by integration data
     *
     * @param BillingPortalRequestInterface $requestData
     * @return BillingPortalResponseInterface
     */
    public function generateMobileKeyByIntegrationData(
        BillingPortalRequestInterface $requestData
    ): BillingPortalResponseInterface {
        $data = $requestData->getIntegrationData();
        $response = $this->curl
            ->addAcceptHeader(Curl::CONTENT_TYPE_JSON)
            ->post(
                $this->getRequestUrl(self::GENERATE_KEY_PATH_URL),
                Curl::CONTENT_TYPE_JSON,
                $data
            );

        return $this->convertDataToResponseInterface($response);
    }

    /**
     * Get subscription data by mobile key
     *
     * @param BillingPortalRequestInterface $requestData
     * @return BillingPortalResponseInterface
     */
    public function getSubscriptionDataByMobileKey(
        BillingPortalRequestInterface $requestData
    ): BillingPortalResponseInterface {
        $response = $this->curl
            ->addAcceptHeader(Curl::CONTENT_TYPE_JSON)
            ->get($this->getRequestUrl(self::GET_SUBSCRIPTION_TRIAL_PATH_URL) . $requestData->getApplicationKey());

        return $this->convertDataToResponseInterface($response);
    }

    /**
     * Get subscription data by live token
     *
     * @param BillingPortalRequestInterface $requestData
     * @return BillingPortalResponseInterface
     */
    public function getSubscriptionDataByLiveToken(
        BillingPortalRequestInterface $requestData
    ): BillingPortalResponseInterface {
        $response = $this->curl
            ->addBearerAuth($requestData->getLiveToken())
            ->addAcceptHeader(Curl::CONTENT_TYPE_JSON)
            ->get($this->getRequestUrl(self::GET_SUBSCRIPTION_LIVE_PATH_URL));

        return $this->convertDataToResponseInterface($response);
    }

    /**
     * Convert data to response interface
     *
     * @param array $data
     * @return BillingPortalResponseInterface
     */
    private function convertDataToResponseInterface(array $data): BillingPortalResponseInterface
    {
        $data = $data['data'] ?? $data;
        $responseDataObject = $this->billingPortalResponseFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $responseDataObject,
            $data,
            BillingPortalResponseInterface::class
        );
        return $responseDataObject;
    }

    /**
     * Get full request url
     *
     * @param string $path
     * @return string
     */
    private function getRequestUrl(string $path): string
    {
        return self::BASE_URL . $path;
    }
}

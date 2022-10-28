<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\Service;

use Aheadworks\MobileAppSubscription\Api\SubscriptionManagerInterface;
use Aheadworks\MobileAppSubscription\Api\TokenGeneratorInterface;
use Magento\Framework\DataObject;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Process class for launch token generate
 */
class GeneratorProcess
{
    public const INTEGRATION_NAME = 'Integration for Mobile App by Aheadworks';
    public const SUPPORT_EMAIL = 'awsupport@aheadworks.com';

    /**
     * @var TokenGeneratorInterface
     */
    private TokenGeneratorInterface $tokenGenerator;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var DataObject
     */
    private DataObject $tokenResources;

    /**
     * @var SubscriptionManagerInterface
     */
    private $subscriptionManager;

    /**
     * GeneratorProcess constructor.
     *
     * @param TokenGeneratorInterface $tokenGenerator
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param SubscriptionManagerInterface $subscriptionManager
     * @param DataObject $tokenResources
     */
    public function __construct(
        TokenGeneratorInterface $tokenGenerator,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        SubscriptionManagerInterface $subscriptionManager,
        DataObject $tokenResources
    ) {
        $this->tokenGenerator = $tokenGenerator;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->tokenResources = $tokenResources;
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * Launch generate Integration and Mobile key
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return void
     */
    public function launch(): void
    {
        $defaultStore = $this->storeManager->getWebsite(true)->getDefaultStore();
        $defaultStoreSecureBaseUrl = $defaultStore->getBaseUrl(
            UrlInterface::URL_TYPE_WEB,
            true
        );
        $defaultStoreCustomerSupportSenderName = $this->scopeConfig->getValue(
            'trans_email/ident_support/name',
            ScopeInterface::SCOPE_STORE,
            $defaultStore->getId()
        );
        $defaultStoreCustomerEmail = $this->scopeConfig->getValue(
            'trans_email/ident_support/email',
            ScopeInterface::SCOPE_STORE,
            $defaultStore->getId()
        );
        $result = $this->tokenGenerator->generateMobileKey(
            self::INTEGRATION_NAME,
            self::SUPPORT_EMAIL,
            $defaultStoreCustomerEmail,
            $defaultStoreSecureBaseUrl,
            $defaultStoreCustomerSupportSenderName,
            (int)$defaultStore->getId(),
            $this->tokenResources->getData('resources')
        );
        if (!$result) {
            $this->logger->info(
                __(
                    'Aheadworks_MobileAppSubscription: Warning! Integration already exists or exception has occurred!'
                )
            );
        } else {
            $this->subscriptionManager->updateSubscriptionDataByApi();
        }
    }
}

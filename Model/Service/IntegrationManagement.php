<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\Service;

use Magento\Integration\Model\OauthService;
use Magento\Integration\Model\AuthorizationService;
use Magento\Integration\Model\Oauth\Token;
use Magento\Integration\Model\ResourceModel\Oauth\Token as TokenResource;
use Magento\Integration\Model\Integration;
use Magento\Integration\Api\IntegrationServiceInterface;
use Aheadworks\MobileAppSubscription\Api\Data\IntegrationInterfaceFactory;
use Aheadworks\MobileAppSubscription\Api\Data\IntegrationInterface;

/**
 * Integration Management for TokenGenerator
 */
class IntegrationManagement
{
    /**
     * @var OauthService
     */
    private $oauthService;

    /**
     * @var IntegrationServiceInterface
     */
    private $integrationService;

    /**
     * @var AuthorizationService
     */
    private $authorization;

    /**
     * @var Token
     */
    private $token;

    /**
     * @var TokenResource
     */
    private $tokenResource;

    /**
     * @var IntegrationInterfaceFactory
     */
    private $integrationInterfaceFactory;

    /**
     * IntegrationManagement constructor.
     *
     * @param OauthService $oauthService
     * @param AuthorizationService $authorization
     * @param Token $token
     * @param TokenResource $tokenResource
     * @param IntegrationServiceInterface $integrationService
     * @param IntegrationInterfaceFactory $integrationInterfaceFactory
     */
    public function __construct(
        OauthService $oauthService,
        AuthorizationService $authorization,
        Token $token,
        TokenResource $tokenResource,
        IntegrationServiceInterface $integrationService,
        IntegrationInterfaceFactory $integrationInterfaceFactory
    ) {
        $this->oauthService = $oauthService;
        $this->authorization = $authorization;
        $this->token = $token;
        $this->tokenResource = $tokenResource;
        $this->integrationService = $integrationService;
        $this->integrationInterfaceFactory = $integrationInterfaceFactory;
    }

    /**
     * Create Integration
     *
     * @param string $name
     * @param string $supportEmail
     * @param string $customerEmail
     * @param string $endpoint
     * @param string $customerName
     * @param int $storeId
     * @param array $resources
     * @return IntegrationInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\IntegrationException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Oauth\Exception
     */
    public function create(
        string $name,
        string $supportEmail,
        string $customerEmail,
        string $endpoint,
        string $customerName,
        int $storeId,
        array $resources = []
    ): IntegrationInterface {
        // Code to create Integration
        $integration = $this->integrationService->create([
            Integration::NAME => $name,
            Integration::EMAIL => $supportEmail,
            Integration::ENDPOINT => $endpoint,
            Integration::STATUS => Integration::STATUS_ACTIVE,
            Integration::SETUP_TYPE => Integration::TYPE_MANUAL
        ]);
        $consumer = $this->oauthService->loadConsumer($integration->getConsumerId());

        // Code to grant permission
        $this->authorization->grantPermissions($integration->getId(), $resources);

        // Code to Activate and Authorize
        $token = $this->token->createVerifierToken($consumer->getId());
        $token->setType(Token::TYPE_ACCESS);
        $this->tokenResource->save($token);

        $integrationObject = $this->integrationInterfaceFactory->create();

        return $integrationObject->setName($integration->getName())
            ->setCustomerEmail($customerEmail)
            ->setInstanceUrl($integration->getEndpoint())
            ->setConsumerKey($consumer->getKey())
            ->setConsumerSecret($consumer->getSecret())
            ->setCustomerName($customerName)
            ->setAccessToken($token->getToken())
            ->setAccessTokenSecret($token->getSecret())
            ->setInstanceStoreId($storeId);
    }

    /**
     * Checking for integration
     *
     * @param string $name
     * @return bool
     */
    public function isExistIntegration(string $name): bool
    {
        return (bool)$this->integrationService->findByName($name)->getId();
    }

    /**
     * Delete Integration by name
     *
     * @param string $name
     * @return bool
     * @throws \Magento\Framework\Exception\IntegrationException
     */
    public function delete(string $name): bool
    {
        $integrationId = $this->integrationService->findByName($name)->getId();
        if ($integrationId) {
            $this->integrationService->delete($integrationId);
            return true;
        }
        return false;
    }
}

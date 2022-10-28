<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model;

use Aheadworks\MobileAppSubscription\Api\Data\IntegrationInterface;
use Magento\Framework\DataObject;

/**
 * Class Integration
 */
class Integration extends DataObject implements IntegrationInterface
{
    /**
     * Set name
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setName(string $value): IntegrationInterface
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set customer email
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setCustomerEmail(string $value): IntegrationInterface
    {
        return $this->setData(self::CUSTOMER_EMAIL, $value);
    }

    /**
     * Get customer email
     *
     * @return string|null
     */
    public function getCustomerEmail(): ?string
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set instance url
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setInstanceUrl(string $value): IntegrationInterface
    {
        return $this->setData(self::INSTANCE_URL, $value);
    }

    /**
     * Get instance url
     *
     * @return string|null
     */
    public function getInstanceUrl(): ?string
    {
        return $this->getData(self::INSTANCE_URL);
    }

    /**
     * Set consumer key
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setConsumerKey(string $value): IntegrationInterface
    {
        return $this->setData(self::CONSUMER_KEY, $value);
    }

    /**
     * Get consumer key
     *
     * @return string|null
     */
    public function getConsumerKey(): ?string
    {
        return $this->getData(self::CONSUMER_KEY);
    }

    /**
     * Set consumer secret
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setConsumerSecret(string $value): IntegrationInterface
    {
        return $this->setData(self::CONSUMER_SECRET, $value);
    }

    /**
     * Get consumer secret
     *
     * @return string|null
     */
    public function getConsumerSecret(): ?string
    {
        return $this->getData(self::CONSUMER_SECRET);
    }

    /**
     * Set customer name
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setCustomerName(string $value): IntegrationInterface
    {
        return $this->setData(self::CUSTOMER_NAME, $value);
    }

    /**
     * Get customer name
     *
     * @return string|null
     */
    public function getCustomerName(): ?string
    {
        return $this->getData(self::CUSTOMER_NAME);
    }

    /**
     * Set access token
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setAccessToken(string $value): IntegrationInterface
    {
        return $this->setData(self::ACCESS_TOKEN, $value);
    }

    /**
     * Get access token
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->getData(self::ACCESS_TOKEN);
    }

    /**
     * Set access token secret
     *
     * @param string $value
     * @return IntegrationInterface
     */
    public function setAccessTokenSecret(string $value): IntegrationInterface
    {
        return $this->setData(self::ACCESS_TOKEN_SECRET, $value);
    }

    /**
     * Get access token secret
     *
     * @return string|null
     */
    public function getAccessTokenSecret(): ?string
    {
        return $this->getData(self::ACCESS_TOKEN_SECRET);
    }

    /**
     * Set instance store id
     *
     * @param int $value
     * @return IntegrationInterface
     */
    public function setInstanceStoreId(int $value): IntegrationInterface
    {
        return $this->setData(self::INSTANCE_STORE_ID, $value);
    }

    /**
     * Get instance store id
     *
     * @return int|null
     */
    public function getInstanceStoreId(): ?int
    {
        return $this->getData(self::INSTANCE_STORE_ID);
    }
}

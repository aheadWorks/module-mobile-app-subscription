<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface IntegrationInterface
 */
interface IntegrationInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    public const NAME = 'name';
    public const CUSTOMER_EMAIL = 'customer_email';
    public const INSTANCE_URL = 'instance_url';
    public const CONSUMER_KEY = 'consumer_key';
    public const CONSUMER_SECRET = 'consumer_secret';
    public const CUSTOMER_NAME = 'customer_name';
    public const ACCESS_TOKEN = 'access_token';
    public const ACCESS_TOKEN_SECRET = 'access_token_secret';
    public const INSTANCE_STORE_ID = 'instance_store_id';
    /**#@-*/

    /**
     * Set name
     *
     * @param string $value
     * @return $this
     */
    public function setName(string $value): IntegrationInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set customer email
     *
     * @param string $value
     * @return $this
     */
    public function setCustomerEmail(string $value): IntegrationInterface;

    /**
     * Get customer email
     *
     * @return string|null
     */
    public function getCustomerEmail(): ?string;

    /**
     * Set instance url
     *
     * @param string $value
     * @return $this
     */
    public function setInstanceUrl(string $value): IntegrationInterface;

    /**
     * Get instance url
     *
     * @return string|null
     */
    public function getInstanceUrl(): ?string;

    /**
     * Set consumer key
     *
     * @param string $value
     * @return $this
     */
    public function setConsumerKey(string $value): IntegrationInterface;

    /**
     * Get consumer key
     *
     * @return string|null
     */
    public function getConsumerKey(): ?string;

    /**
     * Set consumer secret
     *
     * @param string $value
     * @return $this
     */
    public function setConsumerSecret(string $value): IntegrationInterface;

    /**
     * Get consumer secret
     *
     * @return string|null
     */
    public function getConsumerSecret(): ?string;

    /**
     * Set customer name
     *
     * @param string $value
     * @return $this
     */
    public function setCustomerName(string $value): IntegrationInterface;

    /**
     * Get customer name
     *
     * @return string|null
     */
    public function getCustomerName(): ?string;

    /**
     * Set access token
     *
     * @param string $value
     * @return $this
     */
    public function setAccessToken(string $value): IntegrationInterface;

    /**
     * Get access token
     *
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * Set access token secret
     *
     * @param string $value
     * @return $this
     */
    public function setAccessTokenSecret(string $value): IntegrationInterface;

    /**
     * Get access token secret
     *
     * @return string|null
     */
    public function getAccessTokenSecret(): ?string;

    /**
     * Set instance store id
     *
     * @param int $value
     * @return $this
     */
    public function setInstanceStoreId(int $value): IntegrationInterface;

    /**
     * Get instance store id
     *
     * @return int|null
     */
    public function getInstanceStoreId(): ?int;
}

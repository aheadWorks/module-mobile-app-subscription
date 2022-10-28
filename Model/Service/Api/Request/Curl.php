<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model\Service\Api\Request;

use Magento\Framework\HTTP\Client\Curl as CurlClient;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Curl
 */
class Curl
{
    public const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @var CurlClient
     */
    private $curlClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Curl constructor.
     *
     * @param CurlClient $curlClient
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        CurlClient $curlClient,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->curlClient = $curlClient;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * Build and send request by GET method
     *
     * @param string $uri
     * @return array|bool|float|int|string|null
     */
    public function get($uri)
    {
        try {
            $this->curlClient->get($uri);
            $this->validateResponse();
            $responseData = $this->serializer->unserialize($this->curlClient->getBody());
            if (!is_array($responseData)) {
                $responseData = $this->serializer->unserialize($responseData);
            }
            return $responseData;
        } catch (\Exception $e) {
            $this->logger->error($e, ['response' => $this->curlClient->getBody()]);
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * Build and send request by POST method
     *
     * @param string $uri
     * @param string|null $contentType
     * @param array $body
     * @return array|bool|float|int|string|null
     */
    public function post($uri, $contentType, $body = [])
    {
        try {
            $this->curlClient->addHeader("Content-Type", $contentType);
            $this->curlClient->post($uri, $this->serializer->serialize($body));
            $this->validateResponse();
            $responseData = $this->serializer->unserialize($this->curlClient->getBody());
            if (!is_array($responseData)) {
                $responseData = $this->serializer->unserialize($responseData);
            }
            return $responseData;
        } catch (\Exception $e) {
            $this->logger->error($e, ['response' => $this->curlClient->getBody()]);
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * Add bearer token to authorization
     *
     * @param string $authToken
     * @return Curl
     */
    public function addBearerAuth(string $authToken): Curl
    {
        $this->curlClient->addHeader("Authorization", "Bearer ". $authToken);
        return $this;
    }

    /**
     * Add accept value to header
     *
     * @param string $value
     * @return Curl
     */
    public function addAcceptHeader(string $value): Curl
    {
        $this->curlClient->addHeader("Accept", $value);
        return $this;
    }

    /**
     * Validate curl response
     *
     * @throws \Exception
     * @return void
     */
    private function validateResponse(): void
    {
        $status = $this->curlClient->getStatus();
        if ($status < 200 || $status > 299) {
            throw new \Exception("Request Exception HTTP status code: " . $status . ', ' .
                $this->curlClient->getBody());
        }
    }
}

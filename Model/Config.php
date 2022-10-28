<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\Config\Backend\Encrypted;

/**
 * Class Config of system settings
 */
class Config
{
    public const XML_PATH_LIVE_TOKEN_VALUE = 'aw_mac/aw_mac_setting/live_token_value';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Encrypted
     */
    private $encryptor;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Encrypted $encryptor
     */
    public function __construct(ScopeConfigInterface $scopeConfig, Encrypted $encryptor)
    {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
    }

    /**
     * Get live token value
     *
     * @param bool $isDecrypted
     * @return string|null
     */
    public function getLiveTokenValue($isDecrypted = false): ?string
    {
        $configVal = $this->scopeConfig->getValue(
            self::XML_PATH_LIVE_TOKEN_VALUE,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
        if ($configVal && $isDecrypted) {
            $configVal = $this->encryptor->processValue($configVal);
        }
        return $configVal;
    }
}

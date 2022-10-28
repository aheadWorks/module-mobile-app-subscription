<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Plugin\Controller\Adminhtml\Overview;

use Magento\Framework\Controller\ResultFactory;
use Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview\Index as MobileConnectorIndex;
use Magento\Framework\Controller\Result\Forward;

/**
 * Class Plugin for Index
 */
class Index
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * Index constructor.
     *
     * @param ResultFactory $resultFactory
     */
    public function __construct(ResultFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }

    /**
     * Around plugin for execute method
     *
     * @param MobileConnectorIndex $subject
     * @param callable $proceed
     * @return Forward
     */
    public function aroundExecute(MobileConnectorIndex $subject, callable $proceed): Forward
    {
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward
            ->setModule('mobileappsubscription')
            ->setController('overview')
            ->forward('index');
    }
}

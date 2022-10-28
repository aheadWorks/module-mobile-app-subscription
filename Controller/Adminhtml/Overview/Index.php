<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Controller\Adminhtml\Overview;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller Overview Index
 */
class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_overview';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            self::ADMIN_RESOURCE
        )->addBreadcrumb(
            __('Overview'),
            __('Overview')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Overview'));
        return $resultPage;
    }
}

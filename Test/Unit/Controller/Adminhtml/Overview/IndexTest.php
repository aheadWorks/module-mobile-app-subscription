<?php
namespace Aheadworks\MobileAppSubscription\Test\Unit\Controller\Adminhtml\Overview;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\PageFactory;
use Aheadworks\MobileAppSubscription\Controller\Adminhtml\Overview\Index;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Test for \Aheadworks\TokenGenerator\Controller\Adminhtml\Overview\Index
 */
class IndexTest extends TestCase
{
    /**
     * @var ObjectManagerHelper
     */
    private $objectManagerHelper;

    /**
     * @var Page|MockObject
     */
    private $resultPageMock;

    /**
     * @var PageFactory|MockObject
     */
    private $resultPageFactoryMock;

    /**
     * @var Page|MockObject
     */
    private $pageConfigMock;

    /**
     * @var Title|MockObject
     */
    private $titleMock;

    /**
     * @var Index
     */
    private $indexController;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->resultPageFactoryMock = $this->getMockBuilder(PageFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resultPageMock = $this->getMockBuilder(Page::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->pageConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getTitle'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->titleMock = $this->getMockBuilder(Title::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->indexController =  $this->objectManagerHelper->getObject(
            Index::class,
            [
                'resultPageFactory' => $this->resultPageFactoryMock
            ]
        );
    }

    /**
     * Testing of return value of execute method
     */
    public function testExecuteResult()
    {
        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultPageMock);
        $this->resultPageMock->expects($this->once())
            ->method('setActiveMenu')
            ->with(Index::ADMIN_RESOURCE)
            ->willReturnSelf();
        $this->resultPageMock->expects($this->once())
            ->method('addBreadcrumb')
            ->withConsecutive(
                [__('Overview'), __('Overview')]
            );
        $this->resultPageMock->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->pageConfigMock);
        $this->pageConfigMock->expects($this->once())->method('getTitle')->willReturn($this->titleMock);
        $this->titleMock->expects($this->once())
            ->method('prepend')->with(__('Overview'))
            ->willReturn($this->resultPageMock);

        $this->assertSame($this->resultPageMock, $this->indexController->execute());
    }
}

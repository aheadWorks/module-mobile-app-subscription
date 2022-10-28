<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppSubscription\Ui\Component;

use Aheadworks\MobileAppSubscription\Model\Subscription;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Mobile App overview DataProvider
 */
class AppOverviewDataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * Constructor AppOverviewDataProvider
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Subscription $subscription
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Subscription $subscription,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->subscription = $subscription;
        $this->request = $request;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $data = [];
        $mobileKey = $this->subscription->getMobileKey();
        $appOverViewFlag = $this->request->getParam($this->getRequestFieldName());
        if ($appOverViewFlag) {
            $data[$appOverViewFlag]['mobile_key'] = $mobileKey;
        }

        return $data;
    }

    /**
     * Add field filter to collection
     *
     * @param \Magento\Framework\Api\Filter $filter
     * @return AppOverviewDataProvider
     */
    public function addFilter(Filter $filter): AppOverviewDataProvider
    {
        return $this;
    }
}

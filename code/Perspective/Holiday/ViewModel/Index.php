<?php
namespace Perspective\Holiday\ViewModel;

use \Magento\Framework\App\Config\ScopeConfigInterface;

class Index implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Perspective\Holiday\Model\ResourceModel\Holiday\CollectionFactory
     */
    private $holidayCollectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    public function __construct(
        \Perspective\Holiday\Model\ResourceModel\Holiday\CollectionFactory $holidayCollectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\ProductRepository $productRepository
    )
    {
        $this->holidayCollectionFactory = $holidayCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
    }

    public function isEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT): bool
    {
        return $this->scopeConfig->isSetFlag(
            'holiday/general/enable',
            $scope
        );
    }

    public function getHolidayDiscount($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT): int
    {
        return (int)$this->scopeConfig->getValue(
            'holiday/general/discount',
            $scope
        ) ?? 0;
    }
    public function getHolidayCustomerGroups($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'holiday/general/usergroups',
            $scope
        );
    }

    public function getCurrentCustomerGroupId()
    {
        if($this->customerSession->isLoggedIn())
        {
            return $this->customerSession->getCustomer()->getGroupId();
        }
        return 0;
    }

    public function getEnabledHolidays(): ?array
    {
        $res = [];
        if($this->isEnabled())
        {
            if(!is_null($this->getHolidayCustomerGroups()))
            {
                $holidayCustomerGroups = explode(',', $this->getHolidayCustomerGroups());
                if(in_array($this->getCurrentCustomerGroupId(), $holidayCustomerGroups)) {

                    $currentTimestamp = time();

                    $holidayCollection = $this->holidayCollectionFactory->create()
                        ->addFieldToFilter('status', ['eq' => 1]);

                    foreach ($holidayCollection as $holiday) {
                        $holidayStart = strtotime($holiday->getStart());
                        $holidayEnd = strtotime($holiday->getEnd());

                        if ($currentTimestamp >= $holidayStart && $currentTimestamp <= $holidayEnd) {
                            $res[] = $holiday;
                        }
                    }
                }
            }
        }
        return $res;
    }

    public function hasHolidayAttribute($productId)
    {
        return $this->productRepository->getById($productId)->getHoliday();
    }
}

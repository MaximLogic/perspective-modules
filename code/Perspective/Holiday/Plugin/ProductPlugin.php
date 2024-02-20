<?php
namespace Perspective\Holiday\Plugin;

class ProductPlugin
{
    /**
     * @var \Perspective\Holiday\ViewModel\Index
     */
    private $viewModelHelper;

    public function __construct(
        \Perspective\Holiday\ViewModel\Index $viewModelHelper
    )
    {
        $this->viewModelHelper = $viewModelHelper;

    }

    public function afterGetFinalPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $enabledHolidays = $this->viewModelHelper->getEnabledHolidays();
        if(count($enabledHolidays) !== 0 && $subject->getHoliday() == 1)
        {
            $discount = $this->viewModelHelper->getHolidayDiscount();
            return $result - ($result * ($discount / 100));
        }
        return $result;
    }
}

<?php

namespace Perspective\MinimumShippingRate\Plugin\Quote\Model\Quote\Address;

use Magento\Quote\Model\Quote\Address\Rate;
use Magento\Quote\Model\Quote\Address\RateResult\AbstractResult;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Framework\App\Config\ScopeConfigInterface;
class RatePlugin
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isMinimumShippingEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'minimum_shipping_rate/general/enable',
            $scope
        );
    }
    public function getMinimumShippingRate($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'minimum_shipping_rate/general/minimum_rate',
            $scope
        );
    }
    public function afterImportShippingRate(
        Rate $subject,
        Rate $result,
        AbstractResult $rate
    ): Rate
    {
        $minimumShippingRate = (float)$this->getMinimumShippingRate();
        if ($rate instanceof Method &&
            $this->isMinimumShippingEnabled() &&
            $minimumShippingRate >= $result->getPrice())
        {
            $result->setPrice($minimumShippingRate);
        }

        return $result;
    }
}

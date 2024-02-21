<?php

namespace Perspective\FreeShipping\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Checkout\Model\Session;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Index implements ArgumentInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    public function __construct(
        Session $session,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->session = $session;
        $this->scopeConfig = $scopeConfig;
    }

    public function getTotal(): float
    {
        $baseSubTotal = $this->session->getQuote()->getBaseSubtotal();
        return $baseSubTotal;
    }

    public function isFreeShippingEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'free_shipping/general/enable',
            $scope
        );
    }
    public function getFreeShippingMinimumSum($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return (int)$this->scopeConfig->getValue(
            'free_shipping/general/sum',
            $scope
        );
    }

    public function isShippingFree()
    {
        if($this->isFreeShippingEnabled())
        {
            $total = $this->getTotal();
            $freeShippingMinimumSum = $this->getFreeShippingMinimumSum();
            if($total >= $freeShippingMinimumSum)
            {
                return true;
            }
            return $freeShippingMinimumSum - $total;
        }
        return false;
    }
}

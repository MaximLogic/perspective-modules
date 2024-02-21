<?php

namespace Perspective\FreeShipping\Plugin\Quote\Model\Quote\Address;

use Magento\Quote\Model\Quote\Address\Rate;
use Magento\Quote\Model\Quote\Address\RateResult\AbstractResult;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Perspective\FreeShipping\ViewModel\Index;
class RatePlugin
{
    /**
     * @var Perspective\FreeShipping\ViewModel\Index
     */
    private $viewModelHelper;
    public function __construct(
        Index $viewModelHelper
    )
    {
        $this->viewModelHelper = $viewModelHelper;
    }
    public function afterImportShippingRate(
        Rate $subject,
        Rate $result,
        AbstractResult $rate
    ): Rate
    {
        $freeShipping = $this->viewModelHelper->isShippingFree();
        if ($rate instanceof Method && $freeShipping === true) {
            $result->setPrice(0);
        }

        return $result;
    }
}

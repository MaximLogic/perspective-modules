<?php
namespace Perspective\Holiday\Block\adminhtml\Index\Button;

class Generic
{
    protected $context;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->context = $context;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

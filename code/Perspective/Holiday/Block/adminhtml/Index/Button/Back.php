<?php
namespace Perspective\Holiday\Block\adminhtml\Index\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back'
        ];
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}

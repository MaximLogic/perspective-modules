<?php
namespace Perspective\Holiday\Block\adminhtml\Index\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends Generic implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'perspective_holiday_holidays_form.perspective_holiday_holidays_form',
                                'actionName' => 'save',
                                'params' => [false],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

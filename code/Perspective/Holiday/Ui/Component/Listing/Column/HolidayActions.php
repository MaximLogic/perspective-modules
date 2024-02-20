<?php
namespace Perspective\Holiday\Ui\Component\Listing\Column;

class HolidayActions extends \Magento\Ui\Component\Listing\Columns\Column
{

    const URL_EDIT_PATH = 'perspective_holiday/holidays/edit';
    const URL_DELETE_PATH = 'perspective_holiday/holidays/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items']))
        {
            foreach ($dataSource['data']['items'] as &$item)
            {
                if (isset($item['holiday_id']))
                {
                    $item[$this->getData('name')] = [
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_DELETE_PATH,
                                [
                                    'holiday_id' => $item['holiday_id']
                                ]
                            ),
                            'label' => __('Delete'),
                        ],
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_EDIT_PATH,
                                [
                                    'holiday_id' => $item['holiday_id']
                                ]
                            ),
                            'label' => __('Edit'),
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}

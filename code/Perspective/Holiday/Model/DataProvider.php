<?php
namespace Perspective\Holiday\Model;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Perspective\Holiday\Model\ResourceModel\Holiday\CollectionFactory $holidayCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $holidayCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $holiday) {
            $this->loadedData[$holiday->getHolidayId()] = $holiday->getData();
        }
        return $this->loadedData;
    }
}

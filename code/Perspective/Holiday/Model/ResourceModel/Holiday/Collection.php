<?php
namespace Perspective\Holiday\Model\ResourceModel\Holiday;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
	protected $_eventPrefix = 'perspective_holiday_holiday_collection';
	protected $_eventObject = 'holiday_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Perspective\Holiday\Model\Holiday', 'Perspective\Holiday\Model\ResourceModel\Holiday');
    }
}

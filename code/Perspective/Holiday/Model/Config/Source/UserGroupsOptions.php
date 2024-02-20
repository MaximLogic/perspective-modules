<?php
namespace Perspective\Holiday\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class UserGroupsOptions implements ArrayInterface
{

    /**
     * @var Magento\Customer\Model\ResourceModel\Group\Collection
     */
    private $groupCollection;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $groupCollection
    )
    {
        $this->groupCollection = $groupCollection;
        
    }

    public function toOptionArray()
    {
        return $this->groupCollection->toOptionArray();
    }
}
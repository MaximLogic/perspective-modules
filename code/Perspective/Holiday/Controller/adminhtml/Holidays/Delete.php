<?php
namespace Perspective\Holiday\Controller\adminhtml\Holidays;

class Delete extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Perspective\Holiday\Model\HolidayFactory
     */
    private $holidayFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Perspective\Holiday\Model\HolidayFactory $holidayFactory,
    )
    {
        $this->holidayFactory = $holidayFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('holiday_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id)
        {
            try
            {
                $model = $this->holidayFactory->create();
                $model->load($id, 'holiday_id');
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}

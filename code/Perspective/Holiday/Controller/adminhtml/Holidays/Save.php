<?php
namespace Perspective\Holiday\Controller\adminhtml\Holidays;

class Save extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Perspective\Holiday\Model\Holiday
     */
    private $holidayModel;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $adminSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Perspective\Holiday\Model\Holiday $holidayModel,
        \Magento\Backend\Model\Session $adminSession,
    )
    {
        $this->holidayModel = $holidayModel;
        $this->adminSession = $adminSession;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data)
        {
            $holidayId = $this->getRequest()->getParam('id');
            if($holidayId)
            {
                $this->holidayModel->load($holidayId);
            }

            $this->holidayModel->setData($data);
            try
            {
                $this->holidayModel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminSession->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}

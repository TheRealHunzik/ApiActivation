<?php

namespace TheRealHunzik\ApiActivation\Controller\Adminhtml\Activate;
use Magento\Framework\Controller\ResultFactory;
class Index extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultJsonFactory  = $resultJsonFactory;  
        parent::__construct($context);
    }

    /**
     * Execute Function
     *
     * @return JsonFactory
     */
    public function execute()
    {
        /* Call activation API here  */

        /* If you are activated successfully save Token Key in "activatemodule/general/token_key"*/
        
        
        /* Set "activatemodule/general/status" in Core Config to 1 */



        $resultJson = $this->resultJsonFactory->create();
        $data=[
            'result'    =>   'success',
            'message'   =>   'Activated SuccessFully'
        ];
        $resultJson->setData($data);
        return $resultJson;
    }
}
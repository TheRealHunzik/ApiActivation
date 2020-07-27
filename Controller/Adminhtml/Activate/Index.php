<?php

namespace TheRealHunzik\ApiActivation\Controller\Adminhtml\Activate;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\ScopeInterface;
class Index extends \Magento\Backend\App\Action
{

    const XML_PATH_TOKEN_KEY="custommodule/activatemodule/token_key";
    const XML_PATH_STATUS="custommodule/activatemodule/status";

    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultJsonFactory  = $resultJsonFactory;
        $this->_configWriter = $configWriter;
        $this->_storeManager = $storeManager;  
        parent::__construct($context);
    }

    /**
     * Execute Function
     *
     * @return JsonFactory
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $baseUrl="Your Server Url";
        /* Call activation API here  */
        $url= $baseUrl.'/your/api/name';
        $params = new \Zend\Stdlib\Parameters([
            /* Add you Parameters Here */
        ]);
        /* Get Data From Server */
        $resultData = $this->fetchFromServer($url,$params);
        /* If you are activated successfully got Token Key "*/
        if(isset($resultData['token_key'])){
            /* Now save token in COnfig */
            $this->setConfig(self::XML_PATH_TOKEN_KEY,$resultData['token_key']);
            /* Set Activation status 1 */
            $this->setConfig(self::XML_PATH_STATUS,1);
            /* Now Return success message to Button File */
            $data=[
                'result'    =>   'success',
                'message'   =>   'Activated SuccessFully'
            ];
        }else{
            $data=[
                'result'    =>   'error',
                'message'   =>   "Write issue here of return API responnse"
            ];
        }
        $resultJson->setData($data);
        return $resultJson;
    }

    public function fetchFromServer(String $url,$params){
        $httpHeaders = new \Zend\Http\Headers();
        $httpHeaders->addHeaders([
           'Accept' => 'application/json',
           'Content-Type' => 'application/json'
        ]);
        $this->_logger->info($url);
        $zendUri = new \Zend\Uri\Http($url);
        $request = new \Zend\Http\Request();
        $request->setHeaders($httpHeaders);
        $request->setUri($zendUri);
        $request->setMethod(\Zend\Http\Request::METHOD_GET);
        $request->setQuery($params);
        $client = new \Zend\Http\Client();
        $options = [
           'adapter'   => 'Zend\Http\Client\Adapter\Curl',
           'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
           'maxredirects' => 0,
           'timeout' => 30
        ];
        $client->setOptions($options);
        $response = $client->send($request);
        $this->_logger->info($response->getBody());
        $result = json_decode($response->getBody(), 1);
        return $result;
    }

    public function setConfig($path , $value)
    {
        $this->_configWriter->save($path, $value, ScopeInterface::SCOPE_STORES);
    }
}

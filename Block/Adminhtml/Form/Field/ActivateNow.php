<?php

namespace TheRealHunzik\ApiActivation\Block\Adminhtml\Form\Field;

class ActivateNow extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var $template
     */
    protected $_template = 'TheRealHunzik_ApiActivation::form/field/activatenow.phtml';
    /**
     * Constructor
     * @param Context
     * @param array
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }
    /**
     * Render a Component
     * @param AbstractElement
     * @return AbstractElement
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    /**
     * Getting component Html
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }
    /**
     * Get Submit Url
     * @return url
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('custom/activate/index');
    }
    /**
     * Get Button Html
     * @return var
     */
    public function getButtonHtml()
    {
        $status=$this->_scopeConfig->getValue("activatemodule/general/status", "websites");
        /* If Token is set means No button will be Shown */
        if(!$status){
            $button = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Widget\Button'
            )->setData(
                [
                    'id' => 'activate_now',
                    'label' => __('Activate Now'),
                    'class' => 'primary'
                ]
            );
            return $button->toHtml();
        }
        
    }
}
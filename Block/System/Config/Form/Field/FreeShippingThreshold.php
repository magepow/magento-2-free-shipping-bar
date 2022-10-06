<?php
/**
 * Container
 *
 * @copyright Copyright © 2020 Magepow. All rights reserved.
 * @author    @copyright Copyright (c) 2014 Magepow (<https://www.magepow.com>)
 * @license <https://www.magepow.com/license-agreement.html>
 * @Author: magepow<support@magepow.com>
 * @github: <https://github.com/magepow>
 */
namespace Magepow\FreeShippingBar\Block\System\Config\Form\Field;

class FreeShippingThreshold extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{

    /**
     * @var \Magento\Framework\View\Element\BlockInterface
     */
    protected $customerGroupRenderer;

    /**
     * Check if columns are defined, set template
     *
     * @return void
     */
    protected function _construct()
    {
        $this->addColumn(
            'customer_group',
            [
                'label' => __('Customer Group'),
                'style' => 'width: 200px',
                'class' =>  'customer_group_select admin__control-select',
                'renderer' => $this->getCustomerGroupRenderer(),
                
            ]
        );
        // $this->addColumn('threshold', [
        //         'label' => __('Threshold'),
        //         'style' => 'width: 60px',
        //         'class' =>  'input-text required-entry validate-number',
        // ]);
        $this->addColumn('message', [
            'label' => __('Message'),
            'style' => 'width: 700px',
            'class' =>  'input-text required-entry threshold-message',
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
        parent::_construct();

    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getCustomerGroupRenderer()
    {
        if (!$this->customerGroupRenderer) {
            $this->customerGroupRenderer = $this->getLayout()->createBlock(
                \Magepow\FreeShippingBar\Block\Adminhtml\Form\Field\CustomerGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->customerGroupRenderer->setClass('customer_group_select admin__control-select');
            $this->customerGroupRenderer->setStyle('width: 200px');
        }
        return $this->customerGroupRenderer;
    }


    /**
     * @param \Magento\Framework\DataObject $row
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $customerGroup = $row->getCustomerGroup();
        $options = [];
        if ($customerGroup) {
            $options['option_' .
            $this->getCustomerGroupRenderer()->calcOptionHash($customerGroup)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @param string $columnName
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        return parent::renderCellTemplate($columnName);
    }
}

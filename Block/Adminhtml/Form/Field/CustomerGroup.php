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
namespace Magepow\FreeShippingBar\Block\Adminhtml\Form\Field;

class CustomerGroup extends \Magento\Framework\View\Element\Html\Select
{

    /**
     * @var \Magento\Customer\Model\GroupFactory
     */
    protected $groupfactory;

    /**
     * CustomerGroup constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Customer\Model\GroupFactory $groupfactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Customer\Model\GroupFactory $groupfactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->groupfactory = $groupfactory;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $customerGroupCollection = $this->groupfactory->create()->getCollection();
            foreach ($customerGroupCollection as $customerGroup) {
                $this->addOption($customerGroup->getCustomerGroupId(), $customerGroup->getCustomerGroupCode());
            }
        }
        return parent::_toHtml();
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}

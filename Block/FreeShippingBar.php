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
namespace Magepow\FreeShippingBar\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\CartFactory;

class FreeShippingBar extends Template
{

    /**
     * @var \Magepow\FreeShippingBar\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    protected $_cart;

    /**
     * FreeShippingBar constructor.
     * @param Template\Context $context
     * @param \Magepow\FreeShippingBar\Helper\Data $helper
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CartFactory $_cart,
        \Magepow\FreeShippingBar\Helper\Data $helper,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_cart = $_cart;
        parent::__construct($context, $data);
        $this->helper=$helper;
        $this->customerSession = $customerSession;
    }

    
    public function amountsub()
    {
        $model = $this->_cart->create();
        $subtotal = $model->getQuote()->getSubtotal();
        return $subtotal;
    }

    public function getTaxAmount()
    {
        $model = $this->_cart->create();
        return $model->getQuote()->getShippingAddress()->getBaseTaxAmount();
    }


    /**
     * @return int
     */
    public function getCustomerGroup()
    {
        return $this->customerSession->getCustomer()->getGroupId();
    }

    /**
     * @return bool
     */
    public function checkCustomerGroup()
    {
        $thresholds= $this->helper->getThreshold();
        $checkCustomer = $this->customerSession->isLoggedIn() ? $this->getCustomerGroup() : 0;
        if (is_array($thresholds)) {
            foreach ($thresholds as $threshold) {
                if ($threshold['customer_group'] == $checkCustomer) {
                    return $threshold;
                }
            }
        }
        return false;
    }

}

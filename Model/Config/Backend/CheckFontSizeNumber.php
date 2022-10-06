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
namespace Magepow\FreeShippingBar\Model\Config\Backend;

class CheckFontSizeNumber extends \Magento\Framework\App\Config\Value
{
    /**
     * Plugin before Save
     *
     * @return $this
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function beforeSave()
    {

        if (!is_numeric($this->getValue())) {
            throw new \Magento\Framework\Exception\ValidatorException(__('Font Size is not a number.'));
        } elseif ((int)$this->getValue() < 0) {
            throw new \Magento\Framework\Exception\ValidatorException(__(
                'Font Size must be greater than zero.'
            ));
        }

        $this->setValue((int)$this->getValue());

        return parent::beforeSave();
    }
}

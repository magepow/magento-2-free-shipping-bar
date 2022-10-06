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

class ArraySerialized extends \Magento\Config\Model\Config\Backend\Serialized\ArraySerialized
{
    /**
     * @throws \Magento\Framework\Exception\ValidatorException
     * @return void
     */
    public function beforeSave()
    {
        $values = $this->getValue();
        $groupId = [];
        if (is_array($values)) {
            foreach ($values as $value) {
                if (is_array($value)) {
                    $groupId[] = $value['customer_group'];
                    // $threshold = (float) $value['threshold'];
                    // if ($threshold < 0) {
                    //     throw new \Magento\Framework\Exception\ValidatorException(__('Threshold must be positive'));
                    // }
                }
            }
        }
        $countGroupId = count($groupId);
        for ($i = 0; $i < $countGroupId-1; $i++) {
            $check = $groupId[$i];
            for ($j = $i+1; $j < $countGroupId; $j++) {
                if ($check == $groupId[$j]) {
                    throw new \Magento\Framework\Exception\ValidatorException(
                        __('You only can create one rule per one customer group')
                    );
                }
            }
        }

        parent::beforeSave();
    }
}

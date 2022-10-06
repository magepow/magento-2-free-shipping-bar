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
namespace Magepow\FreeShippingBar\Model\Config\Source;

class FontFamily implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'Open Sans', 'label' => __('Open Sans')],
                ['value' => 'Lato', 'label' => __('Lato')],
                ['value' => 'Old Standard TT', 'label' => __('Old Standard TT')],
                ['value' => 'Abril Fatface', 'label' => __('Abril Fatface')],
                ['value' => 'PT Serif', 'label' => __('PT Serif')],
                ['value' => 'Ubuntu', 'label' => __('Ubuntu')],
                ['value' => 'Vollkorn', 'label' => __('Vollkorn')],
                ['value' => 'Droid', 'label' => __('Droid')]];
    }
}

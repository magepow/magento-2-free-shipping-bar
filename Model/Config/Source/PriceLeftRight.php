<?php 

namespace Magepow\FreeShippingBar\Model\Config\Source;

class PriceLeftRight implements \Magento\Framework\Option\ArrayInterface
{
	/**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'left', 'label' => __('Symbol Left')],
            ['value' => 'right', 'label' => __('Symbol Right')]
        ];
    }
}
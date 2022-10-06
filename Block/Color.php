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

class Color extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = $element->getElementHtml();
        $value = $element->getData('value');

        $html .= '<script type="text/javascript">
            require(["jquery","Magepow_FreeShippingBar/js/colorpicker"], function ($) {
                $(document).ready(function () {
                    var el = $("#' . $element->getHtmlId() . '");
                    el.css("backgroundColor", "'. $value .'");
                    el.ColorPicker({
                        color: "'. $value .'",
                        onChange: function (hsb, hex, rgb) {
                            el.css("backgroundColor", "#" + hex).val("#" + hex);
                        }
                    });
                    var pr=el.parent();
                    pr.append("<p id=\'colorpickerHolder\'></p>");
                    $(\'#colorpickerHolder\').ColorPicker({flat: true});
                    $(\'.colorpicker\').css(\'display\',\'none\');
                });
            });
            </script>';
        return $html;
    }
}

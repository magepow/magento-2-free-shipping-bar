/**
 * Container
 *
 * @copyright Copyright © 2020 Magepow. All rights reserved.
 * @author    @copyright Copyright (c) 2014 Magepow (<https://www.magepow.com>)
 * @license <https://www.magepow.com/license-agreement.html>
 * @Author: magepow<support@magepow.com>
 * @github: <https://github.com/magepow>
 */
define([
    'jquery',
    'underscore',
    'Magento_Customer/js/customer-data',
    'Magento_Customer/js/model/customer',
    'Magento_Catalog/js/price-utils',
    'jquery/ui',
    'domReady!'
], function ($, _, customerData, customer, priceUltil) {
    "use strict";
    
    $.widget('message.ajax', {
        options: {
            renderedMessage: 0, // 0 or 1
            sticker: 0, // 0 or 1
            layoutPosition: 'top-page', // top-page or top
            selectorBar: '.free-shipping-bar',
            selectorMessage: '#free-shipping-bar-message',
            selectorBtnClose: '#btn-close-bar',
        },
        _create: function () {
            this._bind();
            this.slideBar();
            this.scrollSlidebar();
            return this;
        },
        _bind: function () {
            var _this = this;
            var cartData = customerData.get('cart');
            var amountFree              = _this.options.freeShippingAmount ,
                thresholdMessage        = _this.options.thresholdMessage,
                colorPrice              = _this.options.colorPrice,
                timeHide                = (_this.options.autoHideTimer*1000),
                symbol                  = _this.options.symbol;
                

            cartData.subscribe(function (cartInfo) {
                var message = thresholdMessage['message'],
                    rightLeft = _this.options.rightLeft,
                    leftValue = (rightLeft == "left") ? symbol + parseFloat(amountFree - cartInfo['subtotalAmount']).toFixed(2) : parseFloat(amountFree - cartInfo['subtotalAmount']).toFixed(2) + symbol,
                    cartSubtotal = (rightLeft == "left") ? symbol + parseFloat(cartInfo['subtotalAmount']).toFixed(2) : parseFloat(cartInfo['subtotalAmount']).toFixed(2) + symbol,
                    freeShippingAmount = (rightLeft == "left") ? symbol + amountFree.toFixed(2) : amountFree.toFixed(2) + symbol;

                if(message.includes("{freeShippingAmount}") == true ){ 
                    message = message.replace(
                        "{freeShippingAmount}",
                        "<em style=\"color: "+colorPrice+";\"><span class=\"price\">"+freeShippingAmount+"</span></em>"
                    );
                }

                if(message.includes("{leftValue}") == true){ 
                    message = message.replace(
                        "{leftValue}",
                        "<em style=\"color: "+colorPrice+";\"><span class=\"price\">"+leftValue+"</span></em>"
                    );
                }
                if(message.includes("{cartSubtotal}") == true){ 
                    message = message.replace(
                        "{cartSubtotal}",
                        "<em style=\"color: "+colorPrice+";\"><span class=\"price\">"+cartSubtotal+"</span></em>"
                    );
                }
                if((amountFree - cartInfo['subtotalAmount']) <= 0){
                    message = _this.options.messageSuccess;
                }

                $(_this.options.selectorMessage).html(message);
                if(_this.options.autoHideTimer != 0){
                    setTimeout(function(){
                        $(_this.options.selectorMessage).slideDown();
                    }, 500);
                }

                this.slideBar();

            }, this);
        },

        slideBar: function() {
            var self = this,
                timeHide                = (self.options.autoHideTimer*1000);
            if(self.options.autoHideTimer != 0){
                setTimeout(function(){
                    $(self.options.selectorMessage).slideUp();
                }, timeHide);
            }
        },

        scrollSlidebar: function() {
            var self = this;
            if(!self.options.position) return;
            var messgeOsTop     = $(self.options.selectorMessage).offset().top;
            $(window).on('scroll', function(){
                let scrollTop       = $(window).scrollTop();
                if((messgeOsTop - scrollTop) <= 0){
                    let widthMessage = $(self.options.selectorMessage).width(),
                        windowWidth  = window.innerWidth,
                        left         = (windowWidth - widthMessage)/2-10;
                    $(self.options.selectorMessage).css({
                        'left': left+'px',
                    }).addClass('position-message');
                }else{
                    $(self.options.selectorMessage).css({
                        'left': 0,
                    }).removeClass('position-message');
                }
            });
         
        }

    });

    return $.message.ajax;
});
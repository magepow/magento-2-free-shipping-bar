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
namespace Magepow\FreeShippingBar\Helper;

use Magento\Framework\Serialize\Serializer\Json;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Framework\App\ProductMetadata
     */
    protected $productMetadata;

    /**
     * @var Json
     */
    protected $json;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Serialize
     */
    protected $serialize;


        /**
     * @var array
     */
    protected $configModule;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ProductMetadata $productMetadata
     * @param Json $json
     * @param \Magento\Framework\Serialize\Serializer\Serialize $serialize
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ProductMetadata $productMetadata,
        Json $json,
        \Magento\Framework\Serialize\Serializer\Serialize $serialize,
        \Magento\Framework\Module\Manager $moduleManager,

    ) {
    
        $this->storeManager = $storeManager;
        $this->productMetadata = $productMetadata;
        $this->json = $json;
        $this->serialize = $serialize;
        parent::__construct($context);
        $this->moduleManager = $moduleManager;
        $this->configModule = $this->getConfig(strtolower($this->_getModuleName()));
    }

    /**
     * Get Store.
     *
     * @return \Magento\Store\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }

    public function getConfig($cfg='')
    {
        if($cfg) return $this->scopeConfig->getValue( $cfg, \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
        return $this->scopeConfig;
    }



    public function getConfigModule($cfg='', $value=null)
    {
        $values = $this->configModule;
        if( !$cfg ) return $values;
        $config  = explode('/', $cfg);
        $end     = count($config) - 1;
        foreach ($config as $key => $vl) {
            if( isset($values[$vl]) ){
                if( $key == $end ) {
                    $value = $values[$vl];
                }else {
                    $values = $values[$vl];
                }
            } 

        }
        return $value;
    }


    /**
     * @return array
     */
    public function getThreshold()
    {
        $arr = [];
        $tableConfig = $this->getConfig('magepow_freeshippingbar/general/free_shipping_threshold');
        if ($tableConfig) {
            if (version_compare($this->productMetadata->getVersion(), '2.2.0', '>')) {
                $tableConfigResults = $this->json->unserialize($tableConfig);
            } else {
                $tableConfigResults =  $this->serialize->unserialize($tableConfig);
            }
            if (is_array($tableConfigResults)) {
                $i=0;
                foreach ($tableConfigResults as $tableConfigResult) {
                    $arr[$i]['customer_group'] = $tableConfigResult['customer_group'];
                    // $arr[$i]['threshold'] = $tableConfigResult['threshold'];
                    $arr[$i]['message'] = $tableConfigResult['message'];
                    $i++;
                }
            }
        }
        return $arr;
    }
}

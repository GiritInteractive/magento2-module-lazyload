<?php
/**
 * Girit-Interactive
 * http://www.girit-tech.com
 * +972-3-9177788
 * info@girit.biz
 *
 * @package     Girit_LazyLoad
 * @author      Pniel Cohen <pini@girit.biz>
 * @license     https://opensource.org/licenses/OSL-3.0
 * @copyright   © 2018 Girit-Interactive (https://www.girit-tech.com/). All rights reserved.
 */

namespace Girit\LazyLoad\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    //= General Settings
    const XML_PATH_GENERAL_ENABLED = "girit_lazyload/general_settings/active";
    const XML_PATH_AUTO_REPLACE_CMS_BLOCKS = "girit_lazyload/general_settings/auto_replace_cms_blocks";
    const XML_PATH_IGNORED_CMS_BLOCKS = "girit_lazyload/general_settings/ignored_cms_blocks";

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var array
     */
    protected $_ignoredCmsBlocksArray = null;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
    */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isEnabled()
    {
        return ($this->getConfig(self::XML_PATH_GENERAL_ENABLED)) ? true : false;
    }

    public function isAutoReplaceCmsBlocks()
    {
        return ($this->getConfig(self::XML_PATH_AUTO_REPLACE_CMS_BLOCKS)) ? true : false;
    }

    public function getIgnoredCmsBlocksArray()
    {
        if (!is_null($this->_ignoredCmsBlocksArray)) {
            return $this->_ignoredCmsBlocksArray;
        }
        return $this->_ignoredCmsBlocksArray = (array) array_map('trim', preg_split('/\r\n|\r|\n/', $this->getConfig(self::XML_PATH_IGNORED_CMS_BLOCKS)));
    }

    //=====================================================================================================//
}

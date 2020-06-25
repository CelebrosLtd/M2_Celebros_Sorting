<?php
/*
 * Celebros
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 *
 ******************************************************************************
 * @category    Celebros
 * @package     Celebros_Sorting
 */
namespace Celebros\Sorting\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\DataObject;

class Data extends AbstractHelper
{
    const XML_PATH_SORTING_MAPPING = 'conversionpro/display_settings/sorting_mapping_grid';

    public function __construct(
        Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return int|null
     */
    public function getMappingValue($store = null) : string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_SORTING_MAPPING,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }
    
    public function getMappingArray($store = null)
    {
        return (array) $this->jsonHelper->jsonDecode(
            $this->getMappingValue($store)
        );
    }
    
    public function getMapppingsByParamName(
        string $paramName,
        string $value
    ) : ?DataObject {
        $return = null;
        foreach ($this->getMappingArray() as $mapping) {
            if (isset($mapping[$paramName])
            && strtolower($mapping[$paramName]) == strtolower($value)) {
                $return = new DataObject();
                foreach ($mapping as $key => $param) {
                    $return->setData($key, $param);
                }
            }
        }
        
        return $return;
    }
}

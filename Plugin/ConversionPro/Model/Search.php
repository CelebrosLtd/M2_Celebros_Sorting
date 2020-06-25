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
namespace Celebros\Sorting\Plugin\ConversionPro\Model;

use Celebros\Sorting\Helper\Data as Helper;
use Magento\Framework\Simplexml\Element as XmlElement;

class Search
{
    /**
     * @var \Celebros\Sorting\Helper\Data $helper
     */
    public $helper;
    
    /**
     * @param \Celebros\Sorting\Helper\Data $helper
     * @return void
     */
    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }
    
    /**
     * @param \Celebros\ConversionPro\Model\Search $search
     * @param \Magento\Framework\Simplexml\Element $return
     * @return \Magento\Framework\Simplexml\Element
     */
    public function afterCreateSearchInfoXml(
        \Celebros\ConversionPro\Model\Search $search,
        XmlElement $return
    ) {
        $fieldName = $return->SortingOptions->getAttribute('FieldName');
        $mapping = $this->helper->getMapppingsByParamName('fieldname', $fieldName);
        
        if ($mapping) {
            $asc = $mapping->getDirection() ? 'true' : 'false';
            $return->SortingOptions->setAttribute('Ascending', $asc);
            $numeric = $mapping->getIsNumeric() ? 'true' : 'false';
            $return->SortingOptions->setAttribute('NumericSort', $numeric);
            if ($fieldNameApi = $mapping->getFieldnameApi()) {
                $return->SortingOptions->setAttribute('FieldName', $fieldNameApi);
            }
        }
        
        /* todo: send $return to conversionpro debug */
        return $return;
    }
}

<?php
/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */
namespace Celebros\Sorting\Plugin\ConversionPro\Model;

use Celebros\ConversionPro\Model\Search as SearchSubject;
use Celebros\Sorting\Helper\Data as Helper;
use Magento\Framework\Simplexml\Element as XmlElement;

class Search
{
    /**
     * @var Helper $helper
     */
    public $helper;

    /**
     * @param Helper $helper
     * @return void
     */
    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Update sorting mappings
     *
     * @param SearchSubject $search
     * @param XmlElement $return
     * @return XmlElement
     */
    public function afterCreateSearchInfoXml(
        SearchSubject $search,
        XmlElement $return
    ) {
        if (!isset($return->SortingOptions)) {
            return $return;
        }

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

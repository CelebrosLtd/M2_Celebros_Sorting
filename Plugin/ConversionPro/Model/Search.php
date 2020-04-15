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

class Search
{
    public $scopeConfig;
    public $sortings;
    
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }
    
    protected function collectSortingMaps()
    {
        $sortingStrings = $this->scopeConfig->getValue('conversionpro/display_settings/sorting_mapping', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $sortings = explode(";", $sortingStrings);
        foreach ($sortings as $key => $sorting) {
            $mapping = explode("^", $sorting);
            if (isset($mapping[2]) && $mapping[2]) {
                $this->sortings[$mapping[2]] = [
                    'NumericSort' => $mapping[1],
                    'Ascending' => $mapping[0],
                    'ReplaceFieldName' => $mapping[3]
                ];
            }
        }
    }
    
    public function afterCreateSearchInfoXml(\Celebros\ConversionPro\Model\Search $search, $return)
    {
        $this->collectSortingMaps(); //print_r($this->sortings);die;
        $fieldName = $return->SortingOptions->getAttribute('FieldName');
        if (isset($this->sortings[$fieldName])) {
            $numeric = $this->sortings[$fieldName]['NumericSort'] ? : false;
            $asc = $this->sortings[$fieldName]['Ascending'] ? : false;
            if ($asc) {
                $asc = $asc ? 'true' : 'false';
                $return->SortingOptions->setAttribute('Ascending', $asc);
            }
            
            if ($numeric) {
                $numeric = $numeric ? 'true' : 'false';
                $return->SortingOptions->setAttribute('NumericSort', $numeric);
            }

            if (isset($this->sortings[$fieldName]['ReplaceFieldName'])) {
                $return->SortingOptions->setAttribute('FieldName', $this->sortings[$fieldName]['ReplaceFieldName']);
            }
        }
        
        return $return;
    }
}
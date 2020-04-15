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
namespace Celebros\Sorting\Plugin\ConversionPro\Helper;

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
            if (isset($mapping[3]) && $mapping[3]) {
                $this->sortings[strtolower($mapping[3])] = strtolower($mapping[2]);
            }
        }
    }
   
    
    public function afterSortOrderMap(\Celebros\ConversionPro\Helper\Search $search, $order)
    {
        $this->collectSortingMaps();
        if (isset($this->sortings[$order])) {
            return $this->sortings[$order];
        }        
        return $order;
    }
}
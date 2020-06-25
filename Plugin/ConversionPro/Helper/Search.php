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

use Celebros\Sorting\Helper\Data as Helper;

class Search
{
    const SORT_ORDER_VAR = 'product_list_order';
    
    public $helper;
    public $request;
    
    /**
     * @param \Celebros\Sorting\Helper\Data $helper
     * @param \Magento\Framework\App\RequestInterface $request
     * @return void
     */
    public function __construct(
        Helper $helper,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->helper = $helper;
        $this->request = $request;
    }
   
    protected function getRequestSortOrder()
    {
        return (string)$this->request->getParam(self::SORT_ORDER_VAR);
    }
    
    public function afterSortOrderMap(\Celebros\ConversionPro\Helper\Search $search, $order)
    {
        $mapOrder = $this->helper->getMapppingsByParamName(
            'fieldname',
            $this->getRequestSortOrder()
        );
        
        if ($mapOrder) {
            return strtolower($mapOrder->getFieldname());
        }
        
        return $order;
    }
}

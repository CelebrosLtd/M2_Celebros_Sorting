<?php
/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */
namespace Celebros\Sorting\Plugin\ConversionPro\Helper;

use Celebros\ConversionPro\Helper\Search as SearchHelper;
use Celebros\Sorting\Helper\Data as Helper;
use Magento\Catalog\Model\Product\ProductList\Toolbar;
use Magento\Framework\App\RequestInterface;

class Search
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Search constructor
     *
     * @param Helper $helper
     * @param RequestInterface $request
     * @return void
     */
    public function __construct(
        Helper $helper,
        RequestInterface $request
    ) {
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * Get sort order field from the request
     *
     * @return string
     */
    protected function getRequestSortOrder()
    {
        return (string)$this->request->getParam(Toolbar::ORDER_PARAM_NAME);
    }

    /**
     * Update order mappings
     *
     * @param SearchHelper $search
     * @param string $order
     * @return string
     */
    public function afterSortOrderMap(SearchHelper $search, $order)
    {
        $mapOrder = $this->helper->getMapppingsByParamName(
            'fieldname',
            $this->getRequestSortOrder()
        );

        if ($mapOrder) {
            return strtolower((string) $mapOrder->getFieldname());
        }

        return $order;
    }
}

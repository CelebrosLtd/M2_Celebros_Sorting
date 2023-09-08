<?php
/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */
namespace Celebros\Sorting\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    public const XML_PATH_SORTING_MAPPING = 'conversionpro/display_settings/sorting_mapping_grid';

    /**
     * @var Json
     */
    private $json;

    /**
     * Data constructor
     *
     * @param Context $context
     * @param Json $json
     */
    public function __construct(
        Context $context,
        Json $json
    ) {
        $this->json = $json;
        parent::__construct($context);
    }

    /**
     * Get sorting mapping value as string
     *
     * @param int|string|null $store
     * @return string
     */
    public function getMappingValue($store = null) : string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_SORTING_MAPPING,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get sorting mapping value as array
     *
     * @param null|int|string $store
     * @return array
     */
    public function getMappingArray($store = null): array
    {
        return (array) $this->json->unserialize(
            $this->getMappingValue($store)
        );
    }

    /**
     * Get sorting mapping for specific sorting field
     *
     * @param string $paramName
     * @param string $value
     * @return DataObject|null
     */
    public function getMapppingsByParamName(
        string $paramName,
        string $value
    ) : ?DataObject {
        $return = null;
        foreach ($this->getMappingArray() as $mapping) {
            if (isset($mapping[$paramName])
            && strtolower((string) $mapping[$paramName]) == strtolower($value)) {
                $return = new DataObject();
                foreach ($mapping as $key => $param) {
                    $return->setData($key, $param);
                }
            }
        }

        return $return;
    }
}

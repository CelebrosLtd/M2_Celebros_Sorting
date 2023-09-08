<?php
/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */
namespace Celebros\Sorting\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class SortingMapping extends AbstractFieldArray
{
    /**
     * Prepare sorting mapping form for rendering
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('direction', ['label' => __('Ascending'), 'class' => 'required-entry']);
        $this->addColumn('is_numeric', ['label' => __('Is Numeric'), 'class' => 'required-entry']);
        $this->addColumn('fieldname', ['label' => __('Field Name'), 'class' => 'required-entry']);
        $this->addColumn('fieldname_api', ['label' => __('Field Name in API'), 'class' => '']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Mapping');
    }
}

<?php
/**
 * Inchoo
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Please do not edit or add to this file if you wish to upgrade
 * Magento or this extension to newer versions in the future.
 * Inchoo developers (Inchooer's) give their best to conform to
 * "non-obtrusive, best Magento practices" style of coding.
 * However, Inchoo does not guarantee functional accuracy of
 * specific extension behavior. Additionally we take no responsibility
 * for any possible issue(s) resulting from extension usage.
 * We reserve the full right not to provide any kind of support for our free extensions.
 * Thank you for your understanding.
 *
 * @category    Inchoo
 * @package     Inchoo_LoginAsCustomer
 * @author      Branko Ajzele <ajzele@gmail.com>
 * @copyright   Copyright (c) Inchoo (http://inchoo.net/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Inchoo_LoginAsCustomer_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_loginAsCustomer');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('core/website')
                            ->getCollection();

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('website_title', array(
            'header'        => Mage::helper('core')->__('Website Name'),
            'align'         =>'left',
            'index'         => 'name',
//            'filter_index'  => 'main_table.name',
//            'renderer'      => 'inchoo_loginAsCustomer/adminhtml_system_store_grid_render_website'
            'renderer'  => 'inchoo_loginAsCustomer/adminhtml_edit_renderer_website'
        ));

        return parent::_prepareColumns();
    }
}

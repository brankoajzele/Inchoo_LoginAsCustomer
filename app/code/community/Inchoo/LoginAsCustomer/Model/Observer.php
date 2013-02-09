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
class Inchoo_LoginAsCustomer_Model_Observer
{
    public function injectLoginAsCustomerButton($observer)
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Customer_Edit) {
            if ($this->getCustomer() && $this->getCustomer()->getId()) {
                $block->addButton('loginAsCustomer', array(
                    'label' => Mage::helper('customer')->__('Login as Customer'),
                    'onclick' => 'setLocation(\'' . $this->getLoginAsCustomerUrl() . '\')',
                    'class' => 'loginAsCustomer',
                ), 0);
            }
        }
    }

    public function getCustomer()
    {
        return Mage::registry('current_customer');
    }

    public function getLoginAsCustomerUrl()
    {
        /*
            If option "System > Configuration > Customers > Customer Configuration > Account Sharing Options > Share Customer Accounts"
            is set to "Per Website" value. What this means is that this account is tied to single website.
        */
        if (Mage::getSingleton('customer/config_share')->isWebsiteScope()) {
            return Mage::helper('adminhtml')->getUrl('*/inchoo_LoginAsCustomer/login', array(
                'customer_id' => $this->getCustomer()->getId(),
                'website_id' => $this->getCustomer()->getWebsiteId(),
            ));
        }

        /* else, this means we have "Global", so customer can login to any website, so we show him the list of websites */
        return Mage::helper('adminhtml')->getUrl('*/inchoo_LoginAsCustomer/index', array('customer_id' => $this->getCustomer()->getId()));
    }
}

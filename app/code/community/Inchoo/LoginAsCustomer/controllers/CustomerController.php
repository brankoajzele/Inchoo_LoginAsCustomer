<?php

class Inchoo_LoginAsCustomer_CustomerController extends Mage_Core_Controller_Front_Action
{
    public function loginAction()
    {
        /* parse the 'loginAsCustomer' param */
        $info = unserialize(
            Mage::helper('core')->decrypt( /* important step; use Magento encryption key to decrypt/extract info */
                base64_decode(
                    $this->getRequest()->getParam('loginAsCustomer')
                )
            )
        );

        /* Check to be sure that all 'website_id' & 'customer_id' & 'timestamp' info is passed */
        if (isset($info['website_id'])
            && isset($info['customer_id'])
            && isset($info['timestamp'])
            && (time() < ($info['timestamp'] + 5))) { /* 5 second validity for request */

                $customerSession = Mage::getSingleton('customer/session');

                /* Share Customer Accounts is set to "Per Website" */
                if (Mage::getSingleton('customer/config_share')->isWebsiteScope()) {
                    if (Mage::app()->getWebsite()->getId() != $info['website_id']) {
                        Mage::getSingleton('customer/session')->addNotice($this->__('<i>Share Customer Accounts</i> option is set to <i>Per Website</i>. You are trying to login as customer from website %d into website %s. This action is not allowed.', $info['website_id'], Mage::app()->getWebsite()->getId()));
                        $this->_redirect('customer/account');
                        return;
                    }
                }

                /* Logout any currently logged in customer */
                if ($customerSession->isLoggedIn()) {
                    $customerSession->logout();
                    $this->_redirectUrl($this->getRequest()->getRequestUri());
                    return;
                }

                /* Login new customer as requested on the admin interface */
                $customerSession->loginById($info['customer_id']);
        }

        $this->_redirect('customer/account');
    }
}

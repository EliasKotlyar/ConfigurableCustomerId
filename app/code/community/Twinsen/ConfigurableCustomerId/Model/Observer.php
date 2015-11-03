<?php
class Twinsen_ConfigurableCustomerId_Model_Observer extends Mage_Core_Model_Abstract
{
    /*
     * observer for the customer saved event
     */
    public function customer_save_before( $observer )
    {
        $customer = $observer->getCustomer();
        if($customer->getId() == null) {
            // New Customer: Assign the ID according to the Prefix.
            $websiteId = $customer->getData("website_id");
            $website = Mage::getModel('core/website')->load($websiteId);
            $customerIncrementId = $website->getCustomerId();
            if($customerIncrementId == null){
                return;
            }
            $customerIncrementId++;
            $customer->setId($customerIncrementId);
            $website->setCustomerId($customerIncrementId);
            $website->save();

        }
    }
    public function adminhtml_store_edit_form_prepare_form($observer){
        $blockClass = $observer->getBlock();
        if (Mage::registry('store_type') == 'website') {
            $storeModel = Mage::registry('store_data');
            $form = $blockClass->getForm();
            $fieldset = $form->getElement('website_fieldset');
            $fieldset->addField('website_customer_id', 'text', array(
                'name'      => 'website[customer_id]',
                'label'     => Mage::helper('core')->__('Customer ID'),
                'value'     => $storeModel->getCustomerId(),
                'required'  => false,
                'disabled'  => $storeModel->isReadOnly(),
            ));
        }
    }

}

?>
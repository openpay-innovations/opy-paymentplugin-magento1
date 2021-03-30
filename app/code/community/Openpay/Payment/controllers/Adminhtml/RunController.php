<?php

class Openpay_Payment_Adminhtml_RunController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Return some checking result
     *
     * @return void
     */
    public function checkAction()
    {
        $result = '';
        $authUser = $this->getRequest()->getParam('auth_user');
        $authToken = $this->getRequest()->getParam('auth_token');
        $paymentMode = $this->getRequest()->getParam('payment_mode');
        $region = $this->getRequest()->getParam('region');
        if ($authUser && $authToken && $paymentMode) {
            $backofficeParams = Mage::helper('openpay_payment')->getBackendParams();
            $backofficeParams['auth_user'] = $authUser;
            $backofficeParams['auth_token'] = $authToken;
            $backofficeParams['payment_mode'] = $paymentMode;
            $backofficeParams['region'] = $region;
            $response = Mage::getModel('openpay_payment/observer')->getLimitsFromOpenpay($backofficeParams);
            if (array_key_exists('message', $response)) {
                $result = 
                [
                    'success' => false,
                    'message' => 'Retailer identity key supplied not valid!'
                ];
            } else {
                $result =
                [
                    'success' => true,
                    'min' => $response['min'], 
                    'max' => $response['max']
                ];
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
    
    protected function _isAllowed()
    {
        return true;
    }
    
}
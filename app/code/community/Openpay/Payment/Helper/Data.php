<?php
/**
 * Helper Class to get Backoffice Data
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Helper_Data extends Mage_Core_Helper_Abstract 
{   
    /** @var int */
    const PATH_ENABLE = 'payment/openpay/active';
    
    /** @var string */
    const PATH_DESCRIPTION = 'payment/openpay/description';
    
    /** @var string */
    const PATH_TITLE = 'payment/openpay/title';
    
    /** @var string */
    const PATH_PAYMENT_MODE = 'payment/openpay/payment_mode';
    
    /** @var string */
    const PATH_AUTH_USER = 'payment/openpay/auth_user';
    
    /** @var string */
    const PATH_AUTH_KEY = 'payment/openpay/auth_key';
    
    /** @var string */
    const PATH_MIN_PRICE = 'payment/openpay/min_price';
    
    /** @var string */
    const PATH_MAX_PRICE = 'payment/openpay/max_price';
    
    /** @var string */
    const PATH_FREQUENCY = 'payment/openpay/frequency';
    
    /** @var string */
    const PATH_DISABLE_CATEGORIES = 'payment/openpay/disable_categories';
    
    /** @var string */
    const PATH_DISABLE_PRODUCTS = 'payment/openpay/disable_products';
    
    /** @var string */
    const PATH_REGION = 'payment/openpay/region';
    
    /** @var string */
    private $openpaySrc = 'https://static.openpay.com.au/brand/logo/amber-lozenge-logo.svg';
    
    /** @var \BusinessLayer\Openpay\PaymentManager */
    private $paymentmanager;
    
     /**
     * @return int
     */
    public function getEnable()
    {   
        return Mage::getStoreConfig(self::PATH_ENABLE, $this->getStoreId());
    }
    
    /**
     * get url from Controller for place order action
     * 
     * @return string
     */
    public function getPaymentGatewayUrl() 
    {
        return Mage::getUrl('openpay/tokenization/gateway', array('_secure' => false));
    }
    
    /**
     * @return string
     */
    public function getPaymentMethodDescription() 
    {
        return Mage::getStoreConfig(self::PATH_DESCRIPTION, $this->getStoreId());
    }

    /**
     * @return string
     */
    public function getTitle() 
    {
        return Mage::getStoreConfig(self::PATH_TITLE, $this->getStoreId());
    }

    /**
     * @return string
     */
    public function getPaymentMode() 
    {
        return Mage::getStoreConfig(self::PATH_PAYMENT_MODE, $this->getStoreId());
    }
    
    /**
     * @return string
     */

    public function getRegion() 
    {
        return Mage::getStoreConfig(self::PATH_REGION, $this->getStoreId());
    }

    /**
     * @return string
     */
    public function getAuthUser() 
    {
        return Mage::getStoreConfig(self::PATH_AUTH_USER, $this->getStoreId());
    }
    
    /**
     * @return string
     */
    public function getAuthKey() 
    {
        return Mage::getStoreConfig(self::PATH_AUTH_KEY, $this->getStoreId());
    }

    /**
     * @return string
     */
    public function getMinPrice() 
    {
        return Mage::getStoreConfig(self::PATH_MIN_PRICE, $this->getStoreId());
    }
    
    /**
     * @return string
     */
    public function getMaxPrice() 
    {
        return Mage::getStoreConfig(self::PATH_MAX_PRICE, $this->getStoreId());
    }
    
    /**
     * @return string
     */
    public function getFrequency() 
    {
        return Mage::getStoreConfig(self::PATH_FREQUENCY, $this->getStoreId());
    }
    
    /**
     * @return string
     */
    public function getDisabledCategories() 
    {
        return Mage::getStoreConfig(self::PATH_DISABLE_CATEGORIES, $this->getStoreId());
    }
    
    /**
     * @return string
     */
    public function getDisabledProducts() 
    {
        return Mage::getStoreConfig(self::PATH_DISABLE_PRODUCTS, $this->getStoreId());
    }
    
    /**
     * @return int
     */
    public function getStoreId()
    {
        return Mage::app()->getStore()->getStoreId();
    }
    
    /**
     * This function will extract all the values of the backend form
     * $backendParams will create new array from all the values
     * 
     * @return array
     */
    public function getBackendParams()
    {
        $backendParams = [
            'auth_user' => $this->getAuthUser(),
            'auth_token' => $this->getAuthKey(),
            'payment_mode' => $this->getPaymentMode(),
            'region' => $this->getRegion(),
            'minimum' => $this->getMinPrice(),
            'maximum' => $this->getMaxPrice()
        ];
        
        return $backendParams;
    }
    
    /**
     * create Paymentmanager instance
     * 
     * @param array|null $backendParams
     * @return \BusinessLayer\Openpay\PaymentManager
     */
    public function getPaymentmanager($backendParams = null)
    {
        require_once dirname( __FILE__ ) . '/../Model/paymentadapter/OpenpayApi/vendor/autoload.php';     
        //if ( ! $this->paymentmanager ) {
            if ($backendParams) {
                $this->paymentmanager = new \BusinessLayer\Openpay\PaymentManager($backendParams);
            } else {
                $this->paymentmanager = new \BusinessLayer\Openpay\PaymentManager($this->getBackendParams());
            }
        //}
        
        return $this->paymentmanager;
    }
    
    /**
     * get picture src for Openpaypicture
     * 
     * @return string
     */
    public function getOpenpaySrc() 
    {
        return $this->openpaySrc;
    }
}

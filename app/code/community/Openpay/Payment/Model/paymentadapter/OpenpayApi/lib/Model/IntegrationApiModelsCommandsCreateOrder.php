<?php
/**
 * IntegrationApiModelsCommandsCreateOrder
 *
 * PHP version 5
 *
 * @category Class
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Integration API
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: v1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.22
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Openpay\Client\Model;

use \ArrayAccess;
use \Openpay\Client\ObjectSerializer;

/**
 * IntegrationApiModelsCommandsCreateOrder Class Doc Comment
 *
 * @category Class
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class IntegrationApiModelsCommandsCreateOrder implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'IntegrationApi.Models.Commands.CreateOrder';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'customer_journey' => '\Openpay\Client\Model\IntegrationApiModelsCommandsCustomerJourney',
'goods_description' => 'string',
'source' => 'string',
'purchase_price' => 'int',
'retailer_order_no' => 'string',
'cart' => '\Openpay\Client\Model\IntegrationApiModelsCommandsCartItem[]'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'customer_journey' => null,
'goods_description' => null,
'source' => null,
'purchase_price' => 'int32',
'retailer_order_no' => null,
'cart' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'customer_journey' => 'customerJourney',
'goods_description' => 'goodsDescription',
'source' => 'source',
'purchase_price' => 'purchasePrice',
'retailer_order_no' => 'retailerOrderNo',
'cart' => 'cart'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'customer_journey' => 'setCustomerJourney',
'goods_description' => 'setGoodsDescription',
'source' => 'setSource',
'purchase_price' => 'setPurchasePrice',
'retailer_order_no' => 'setRetailerOrderNo',
'cart' => 'setCart'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'customer_journey' => 'getCustomerJourney',
'goods_description' => 'getGoodsDescription',
'source' => 'getSource',
'purchase_price' => 'getPurchasePrice',
'retailer_order_no' => 'getRetailerOrderNo',
'cart' => 'getCart'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['customer_journey'] = isset($data['customer_journey']) ? $data['customer_journey'] : null;
        $this->container['goods_description'] = isset($data['goods_description']) ? $data['goods_description'] : null;
        $this->container['source'] = isset($data['source']) ? $data['source'] : null;
        $this->container['purchase_price'] = isset($data['purchase_price']) ? $data['purchase_price'] : null;
        $this->container['retailer_order_no'] = isset($data['retailer_order_no']) ? $data['retailer_order_no'] : null;
        $this->container['cart'] = isset($data['cart']) ? $data['cart'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['customer_journey'] === null) {
            $invalidProperties[] = "'customer_journey' can't be null";
        }
        if ($this->container['purchase_price'] === null) {
            $invalidProperties[] = "'purchase_price' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets customer_journey
     *
     * @return \Openpay\Client\Model\IntegrationApiModelsCommandsCustomerJourney
     */
    public function getCustomerJourney()
    {
        return $this->container['customer_journey'];
    }

    /**
     * Sets customer_journey
     *
     * @param \Openpay\Client\Model\IntegrationApiModelsCommandsCustomerJourney $customer_journey customer_journey
     *
     * @return $this
     */
    public function setCustomerJourney($customer_journey)
    {
        $this->container['customer_journey'] = $customer_journey;

        return $this;
    }

    /**
     * Gets goods_description
     *
     * @return string
     */
    public function getGoodsDescription()
    {
        return $this->container['goods_description'];
    }

    /**
     * Sets goods_description
     *
     * @param string $goods_description Brief description of goods being purchased
     *
     * @return $this
     */
    public function setGoodsDescription($goods_description)
    {
        $this->container['goods_description'] = $goods_description;

        return $this;
    }

    /**
     * Gets source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->container['source'];
    }

    /**
     * Sets source
     *
     * @param string $source Shopsystem
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->container['source'] = $source;

        return $this;
    }

    /**
     * Gets purchase_price
     *
     * @return int
     */
    public function getPurchasePrice()
    {
        return $this->container['purchase_price'];
    }

    /**
     * Sets purchase_price
     *
     * @param int $purchase_price Purchase price of the order  An integer number in the lowest denomination in the currency being used (e.g. supply 1034 to indicate $10.34)
     *
     * @return $this
     */
    public function setPurchasePrice($purchase_price)
    {
        $this->container['purchase_price'] = $purchase_price;

        return $this;
    }

    /**
     * Gets retailer_order_no
     *
     * @return string
     */
    public function getRetailerOrderNo()
    {
        return $this->container['retailer_order_no'];
    }

    /**
     * Sets retailer_order_no
     *
     * @param string $retailer_order_no A retailer reference (e.g. invoice) number for this order
     *
     * @return $this
     */
    public function setRetailerOrderNo($retailer_order_no)
    {
        $this->container['retailer_order_no'] = $retailer_order_no;

        return $this;
    }

    /**
     * Gets cart
     *
     * @return \Openpay\Client\Model\IntegrationApiModelsCommandsCartItem[]
     */
    public function getCart()
    {
        return $this->container['cart'];
    }

    /**
     * Sets cart
     *
     * @param \Openpay\Client\Model\IntegrationApiModelsCommandsCartItem[] $cart An array of the items being purchased in the order
     *
     * @return $this
     */
    public function setCart($cart)
    {
        $this->container['cart'] = $cart;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
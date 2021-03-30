<?php
/**
 * IntegrationApiModelsCommandsCartItem
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
 * IntegrationApiModelsCommandsCartItem Class Doc Comment
 *
 * @category Class
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class IntegrationApiModelsCommandsCartItem implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'IntegrationApi.Models.Commands.CartItem';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'item_name' => 'string',
'item_group' => 'string',
'item_code' => 'string',
'item_group_code' => 'string',
'item_retail_unit_price' => 'int',
'item_qty' => 'string',
'item_retail_charge' => 'int'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'item_name' => null,
'item_group' => null,
'item_code' => null,
'item_group_code' => null,
'item_retail_unit_price' => 'int32',
'item_qty' => null,
'item_retail_charge' => 'int32'    ];

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
        'item_name' => 'itemName',
'item_group' => 'itemGroup',
'item_code' => 'itemCode',
'item_group_code' => 'itemGroupCode',
'item_retail_unit_price' => 'itemRetailUnitPrice',
'item_qty' => 'itemQty',
'item_retail_charge' => 'itemRetailCharge'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'item_name' => 'setItemName',
'item_group' => 'setItemGroup',
'item_code' => 'setItemCode',
'item_group_code' => 'setItemGroupCode',
'item_retail_unit_price' => 'setItemRetailUnitPrice',
'item_qty' => 'setItemQty',
'item_retail_charge' => 'setItemRetailCharge'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'item_name' => 'getItemName',
'item_group' => 'getItemGroup',
'item_code' => 'getItemCode',
'item_group_code' => 'getItemGroupCode',
'item_retail_unit_price' => 'getItemRetailUnitPrice',
'item_qty' => 'getItemQty',
'item_retail_charge' => 'getItemRetailCharge'    ];

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
        $this->container['item_name'] = isset($data['item_name']) ? $data['item_name'] : null;
        $this->container['item_group'] = isset($data['item_group']) ? $data['item_group'] : null;
        $this->container['item_code'] = isset($data['item_code']) ? $data['item_code'] : null;
        $this->container['item_group_code'] = isset($data['item_group_code']) ? $data['item_group_code'] : null;
        $this->container['item_retail_unit_price'] = isset($data['item_retail_unit_price']) ? $data['item_retail_unit_price'] : null;
        $this->container['item_qty'] = isset($data['item_qty']) ? $data['item_qty'] : null;
        $this->container['item_retail_charge'] = isset($data['item_retail_charge']) ? $data['item_retail_charge'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['item_name'] === null) {
            $invalidProperties[] = "'item_name' can't be null";
        }
        if ($this->container['item_code'] === null) {
            $invalidProperties[] = "'item_code' can't be null";
        }
        if ($this->container['item_retail_unit_price'] === null) {
            $invalidProperties[] = "'item_retail_unit_price' can't be null";
        }
        if ($this->container['item_qty'] === null) {
            $invalidProperties[] = "'item_qty' can't be null";
        }
        if ($this->container['item_retail_charge'] === null) {
            $invalidProperties[] = "'item_retail_charge' can't be null";
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
     * Gets item_name
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->container['item_name'];
    }

    /**
     * Sets item_name
     *
     * @param string $item_name A description of the item used by the retailer
     *
     * @return $this
     */
    public function setItemName($item_name)
    {
        $this->container['item_name'] = $item_name;

        return $this;
    }

    /**
     * Gets item_group
     *
     * @return string
     */
    public function getItemGroup()
    {
        return $this->container['item_group'];
    }

    /**
     * Sets item_group
     *
     * @param string $item_group A group level description if available
     *
     * @return $this
     */
    public function setItemGroup($item_group)
    {
        $this->container['item_group'] = $item_group;

        return $this;
    }

    /**
     * Gets item_code
     *
     * @return string
     */
    public function getItemCode()
    {
        return $this->container['item_code'];
    }

    /**
     * Sets item_code
     *
     * @param string $item_code An internal stock number for this item
     *
     * @return $this
     */
    public function setItemCode($item_code)
    {
        $this->container['item_code'] = $item_code;

        return $this;
    }

    /**
     * Gets item_group_code
     *
     * @return string
     */
    public function getItemGroupCode()
    {
        return $this->container['item_group_code'];
    }

    /**
     * Sets item_group_code
     *
     * @param string $item_group_code If a group has an internal code that may be used to refer to it, it can be supplied
     *
     * @return $this
     */
    public function setItemGroupCode($item_group_code)
    {
        $this->container['item_group_code'] = $item_group_code;

        return $this;
    }

    /**
     * Gets item_retail_unit_price
     *
     * @return int
     */
    public function getItemRetailUnitPrice()
    {
        return $this->container['item_retail_unit_price'];
    }

    /**
     * Sets item_retail_unit_price
     *
     * @param int $item_retail_unit_price The individual retail price charged for the item  An integer number in the lowest denomination in the currency being used (e.g. 1034 indicates $10.34)
     *
     * @return $this
     */
    public function setItemRetailUnitPrice($item_retail_unit_price)
    {
        $this->container['item_retail_unit_price'] = $item_retail_unit_price;

        return $this;
    }

    /**
     * Gets item_qty
     *
     * @return string
     */
    public function getItemQty()
    {
        return $this->container['item_qty'];
    }

    /**
     * Sets item_qty
     *
     * @param string $item_qty How many of the items were purchased
     *
     * @return $this
     */
    public function setItemQty($item_qty)
    {
        $this->container['item_qty'] = $item_qty;

        return $this;
    }

    /**
     * Gets item_retail_charge
     *
     * @return int
     */
    public function getItemRetailCharge()
    {
        return $this->container['item_retail_charge'];
    }

    /**
     * Sets item_retail_charge
     *
     * @param int $item_retail_charge The overall retail charge for the quantity of items  An integer number in the lowest denomination in the currency being used (e.g. 1034 indicates $10.34)
     *
     * @return $this
     */
    public function setItemRetailCharge($item_retail_charge)
    {
        $this->container['item_retail_charge'] = $item_retail_charge;

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

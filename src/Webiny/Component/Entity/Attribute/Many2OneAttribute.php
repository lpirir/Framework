<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Entity\Attribute;

use Webiny\Component\Entity\Entity;
use Webiny\Component\StdLib\StdLibTrait;


/**
 * Many2One attribute
 * @package Webiny\Component\Entity\AttributeType
 */
class Many2OneAttribute extends AttributeAbstract
{
    use StdLibTrait;

    protected $_entityClass = null;

    /**
     * Get masked entity value when instance is being converted to string
     *
     * @return mixed|null|string
     */
    public function __toString()
    {
        if($this->isNull($this->_value) && !$this->isNull($this->_defaultValue)) {
            return (string)$this->_defaultValue;
        }

        if($this->isNull($this->_value)) {
            return '';
        }

        return $this->getValue()->getMaskedValue();
    }

    /**
     * Get related entity ID
     * @return CharAttribute
     */
    public function getId()
    {
        $value = $this->getValue();
        if($value) {
            return $value->getId();
        }

        return null;
    }

    /**
     * Get value that will be stored to database
     *
     * @return string
     */
    public function getDbValue()
    {
        $value = $this->getValue();
        if($this->isNull($value)) {
            return null;
        }

        // If what we got is a defaultValue - create or load an actual entity instance
        if($value === $this->_defaultValue) {
            if($this->isArray($value) || $this->isArrayObject($value)) {
                $this->_value = new $this->_entityClass;
                $this->_value->populate($value);
            }

            if(Entity::getInstance()->getDatabase()->isMongoId($value)) {
                $this->_value = call_user_func_array([
                                                         $this->_entityClass,
                                                         'findById'
                                                     ], [$value]);
            }
        }

        if($this->getValue()->getId()->getValue() == null) {
            $this->getValue()->save();
        }

        // Return a simple Entity ID string
        return $this->getValue()->getId()->getValue();
    }

    /**
     * Set entity class for this attribute
     *
     * @param string $entityClass
     *
     * @return $this
     */
    public function setEntity($entityClass)
    {
        $this->_entityClass = $entityClass;

        return $this;
    }

    /**
     * Get entity class for this attribute
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->_entityClass;
    }

    /**
     * Get attribute value
     *
     * @return bool|null|\Webiny\Component\Entity\EntityAbstract
     */
    public function getValue()
    {
        if(!$this->isInstanceOf($this->_value, $this->_entityClass)) {
            $this->_value = call_user_func_array([
                                                     $this->_entityClass,
                                                     'findById'
                                                 ], [$this->_value]
            );
        }

        if(!$this->_value && !$this->isNull($this->_defaultValue)) {
            return $this->_defaultValue;
        }

        return $this->_value;
    }

    /**
     * Set attribute value
     *
     * @param null $value
     *
     * @return $this
     */
    public function setValue($value = null)
    {
        if(!$this->_canAssign()) {
            return $this;
        }

        $this->validate($value);
        if($this->_value != $value) {
            $this->_value = $value;
            $this->_entity->__setDirty(true);
        }

        return $this;
    }

    /**
     * This method allows us to chain getAttribute calls on related entities.
     * Ex: $person->getAttribute('company')->getAttribute('name')->getValue(); // This will output company name
     *
     * @param $name
     *
     * @return AttributeAbstract
     */
    public function getAttribute($name)
    {
        return $this->getValue()->getAttribute($name);
    }

    /**
     * This method allows us to use simplified access to attributes (no autocomplete).
     * Ex: $person->company->name // Will output company name
     *
     * @param $name
     *
     * @return AttributeAbstract
     */
    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    /**
     * Perform validation against given value
     *
     * @param $value
     *
     * @throws ValidationException
     * @return $this
     */
    public function validate(&$value)
    {
        if(!$this->isNull($value) && !$this->isInstanceOf($value, '\Webiny\Component\Entity\EntityAbstract'
            ) && !Entity::getInstance()->getDatabase()->isMongoId($value)
        ) {
            throw new ValidationException(ValidationException::ATTRIBUTE_VALIDATION_FAILED, [
                    $this->_attribute,
                    'entity ID, instance of \Webiny\Component\Entity\EntityAbstract or null',
                    gettype($value)
                ]
            );
        }

        return $this;
    }
}
<?php

namespace Zend\Http;

use ArrayObject,
    Zend\Stdlib\Parameters as ParametersDescription;

class Parameters extends ArrayObject implements ParametersDescription
{
    /**
     * Constructor
     *
     * Enforces that we have an array, and enforces parameter access to array
     * elements.
     * 
     * @param  array $values 
     * @return void
     */
    public function __construct(array $values = null)
    {
        if (null === $values) {
            $values = array();
        }
        parent::__construct($values, ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Populate from native PHP array
     * 
     * @param  array $values 
     * @return void
     */
    public function fromArray(array $values)
    {
        $this->exchangeArray($values);
    }

    /**
     * Populate from query string
     * 
     * @param  string $string 
     * @return void
     */
    public function fromString($string)
    {
        $array = array();
        parse_str($string, $array);
        $this->fromArray($array);
    }

    /**
     * Serialize to native PHP array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * Serialize to query string
     * 
     * @return string
     */
    public function toString()
    {
        return http_build_query($this);
    }

    /**
     * Retrieve by key
     *
     * Returns null if the key does not exist.
     * 
     * @param  string $name 
     * @return mixed
     */
    public function offsetGet($name)
    {
        if (isset($this[$name])) {
            return parent::offsetGet($name);
        }
        return null;
    }
}
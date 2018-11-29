<?php

namespace App\Helper\Validator;

/**
 * Validates the constants of a class.
 */
class ClassConstantValidator
{
    /** @var \ReflectionClass */
    private $reflected;

    /** @var array */
    private $constants;

    /** @var array */
    private $keys;

    /**
     * @param string $class The class name
     *
     * @throws \ReflectionException
     */
    public function __construct(string $class)
    {
        $this->reflected = new \ReflectionClass($class);
        $this->constants = $this->reflected->getConstants();
        $this->keys = array_keys($this->constants);
    }

    /**
     * Verify if a constant with the given name exists in the class.
     *
     * @param string $name The constant's name
     *
     * @return bool
     */
    public function nameExists(string $name)
    {
        return $this->reflected->hasConstant($name);
    }

    /**
     * Verify if a constant with the given value exists in the class.
     *
     * @param mixed $constant The constant's value
     *
     * @return bool
     */
    public function constantExists($constant)
    {
        return in_array($constant, $this->constants);
    }

    /**
     * Verifiy if a constant value exists for a group of constants that match the given pattern.
     *
     * @param mixed $constant The constant's value
     * @param string $pattern The pattern for the constant's name
     *
     * @return bool
     */
    public function isValid($constant, string $pattern = '/^.*/')
    {
        foreach ($this->keys as $key) {
            if (false === empty(preg_match($pattern, $key))) {
                if ($this->reflected->getConstant($key) == $constant) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Verify if a constant value exists for a group of constants that values are between min and max.
     * If max is less than min, ignores max.
     *
     * @param mixed $constant The constant's value
     * @param int $min The min value for the constant
     * @param int $max The max value for the constant
     *
     * @return bool
     */
    public function isValidValue($constant, int $min, int $max = -1)
    {
        foreach ($this->constants as $value) {
            if ($constant < $min) {
                continue;
            }

            if (($min <= $max) && ($value > $max)) {
                continue;
            }

            return $this->isValid($constant);
        }

        return false;
    }
}

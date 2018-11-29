<?php

namespace App\Tests\Helper;

use App\Helper\Validator\ClassConstantValidator;
use App\Tests\Resources\ClassConstant;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClassConstantValidatorTest extends WebTestCase
{
    public function testConstuctor()
    {
        try {
            new ClassConstantValidator('Not\A\Valid\Class');
        } catch (\Exception $ex) {
            $this->assertEquals(\ReflectionException::class, get_class($ex));
        }
    }

    public function testMethods()
    {
        $class = new ClassConstantValidator(ClassConstant::class);
        $this->assertTrue($class->nameExists('FOO'));
        $this->assertFalse($class->nameExists('FEE'));
        $this->assertTrue($class->constantExists(10));
        $this->assertFalse($class->constantExists(20));
        $this->assertTrue($class->isValid(10));
        $this->assertFalse($class->isValid(10, '/^SHARP_.*$/'));
        $this->assertTrue($class->isValid(299, '/^SHARP_.*$/'));
        $this->assertFalse($class->isValidValue(250, 200));
        $this->assertFalse($class->isValidValue(250, 200, 300));
        $this->assertTrue($class->isValidValue(233, 200, 200));
    }
}

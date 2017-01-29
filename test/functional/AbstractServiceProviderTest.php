<?php

namespace Dhii\Di\FuncTest;

use Exception;
use Dhii\Di\AbstractContainer;
use Interop\Container\ServiceProvider;
use Dhii\Di\Stub\ContainerException;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Di\AbstractServiceProvider}.
 *
 * @since [*next-version*]
 */
class AbstractServiceProviderTest extends TestCase
{
    /**
     * The name of the test subject.
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Di\\AbstractServiceProvider';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param ServiceProvider $provider Optional service provider. Default: null
     *
     * @return AbstractContainer
     */
    public function createInstance(array $definitions = array())
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->_createContainerException(function ($m, $code = 0, Exception $prev = null) {
                return new ContainerException($m, $code, $prev);
            })
            ->new();

        foreach ($definitions as $_id => $_definition) {
            $mock->this()->serviceDefinitions = array_merge(
                $mock->this()->serviceDefinitions,
                array($_id => $_definition)
            );
        }

        return $mock;
    }

    /**
     * Create a service definition that returns a simple value.
     *
     * @param mixed $value The value that the service definition will return.
     *
     * @return callable A service definition that will return the given value.
     */
    public function createDefinition($value)
    {
        return function ($container = null, $previous = null) use ($value) {
            return $value;
        };
    }

    /**
     * Tests the service getter method to ensure that all services are correctly retrieved in an array.
     *
     * @since [*next-version*]
     */
    public function testGetServices()
    {
        $definitions = array(
            'one' => $this->createDefinition('one'),
            'two' => $this->createDefinition(2),
            'three' => $this->createDefinition('three'),
        );
        $subject = $this->createInstance($definitions);

        $this->assertEquals($definitions, $subject->this()->_getServices());
    }

    /**
     * Tests the service definition registration method to ensure that definitions are correctly
     * registered in the provider.
     *
     * @since [*next-version*]
     */
    public function testAdd()
    {
        $subject = $this->createInstance();

        $subject->this()->_add('test', $this->createDefinition('this is a test'));
        $subject->this()->_add('pi', $this->createDefinition(3.14159265359));

        $this->assertArrayHasKey('test', $subject->this()->serviceDefinitions);
        $this->assertArrayHasKey('pi', $subject->this()->serviceDefinitions);
    }

    /**
     * Tests the service definition registration method with an invalid definition to ensure that an
     * exception is thrown in such cases.
     *
     * @since [*next-version*]
     */
    public function testAddInvalidDefinition()
    {
        $subject = $this->createInstance();

        $this->setExpectedException('\\Interop\\Container\\Exception\\ContainerException');

        $subject->this()->_add('test', new \DOMText('this is not a definition!'));
    }
}

<?php

namespace Dhii\Di;

use Interop\Container\Exception\ContainerException as ContainerExceptionInterface;
use Interop\Container\ServiceProvider;

/**
 * Abstract implementation of an object that can provide services.
 *
 * @since [*next-version*]
 */
abstract class AbstractServiceProvider
{
    /**
     * The service definitions.
     *
     * @since [*next-version*]
     *
     * @var callable[]
     */
    protected $serviceDefinitions = array();

    /**
     * Gets the service definitions.
     *
     * @since [*next-version*]
     * @see ServiceProvider::getServices()
     *
     * @return callable[]|\Traversable A list of service definitions.
     */
    protected function _getServices()
    {
        return $this->serviceDefinitions;
    }

    /**
     * Adds a service definition to this provider.
     *
     * @since [*next-version*]
     *
     * @param string   $id         The ID of the service definition.
     * @param callable $definition The service definition.
     *
     * @throws ContainerException
     */
    protected function _add($id, $definition)
    {
        // Checking only format, because the definition may become available later
        if (!is_callable($definition, true)) {
            throw $this->_createContainerException(
                sprintf('Could not add service definition with ID "%1$s": The definition must be a callable', $id)
            );
        }

        $this->serviceDefinitions[$id] = $definition;

        return $this;
    }

    /**
     * Creates a new exception that represents a generic DI container error.
     *
     * @since [*next-version*]
     * 
     * @return ContainerExceptionInterface The new exception instance.
     */
    abstract protected function _createContainerException($message, $code = 0, \Exception $innerException = null);
}

<?php

namespace Dhii\Di\Stub;

use Exception;
use Interop\Container\Exception\ContainerException as BaseContainerException;

/**
 * Stub class for container exceptions.
 *
 * Used in testing to allow mocked methods to throw {@see Exception} instances that implement {@see ContainerException}.
 *
 * @since [*next-version*]
 */
class ContainerException extends Exception implements BaseContainerException
{
}

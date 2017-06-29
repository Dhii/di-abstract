<?php

namespace Dhii\Di\Stub;

use Exception;
use Psr\Container\ContainerExceptionInterface as BaseContainerException;

/**
 * Stub class for container exceptions.
 *
 * Used in testing to allow mocked methods to throw {@see Exception} instances that implement {@see ContainerException}.
 *
 * @since 0.1
 */
class ContainerException extends Exception implements BaseContainerException
{
}

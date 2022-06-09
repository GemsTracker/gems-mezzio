<?php


namespace Gems\Mezzio\Error;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;

class ErrorLogEventListenerDelegatorFactory implements DelegatorFactoryInterface
{
    protected string $errorLogger = 'errorLogger';

    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return ErrorHandler
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null): ErrorHandler
    {
        $listener = new ErrorLogEventListener();
        if ($container->has($this->errorLogger)) {
            $listener->setErrorLog($container->get($this->errorLogger));
        }
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }
}

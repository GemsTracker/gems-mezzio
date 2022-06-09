<?php

declare(strict_types=1);

namespace Gems\Mezzio;


use Gems\Mezzio\Error\ErrorLogEventListenerDelegatorFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Monolog\Level;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies'  => $this->getDependencies(),
            'log'           => $this->getLoggers(),
        ];
    }

    protected function getDependencies(): array
    {
        return [
            'delegators' => [
                ErrorHandler::class => [
                    ErrorLogEventListenerDelegatorFactory::class,
                ],
            ],
        ];
    }

    protected function getLoggers(): array
    {
        return [
            'errorLogger' => [
                'writers' => [
                    'stream' => [
                        'name' => 'stream',
                        'priority' => Level::Debug,
                        'options' => [
                            'stream' =>  'data/logs/php-error.log',
                        ],
                    ],
                ],
            ],
        ];
    }
}

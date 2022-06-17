<?php
declare(strict_types=1);

namespace Zyimm\HyperfMultiEnv\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zyimm\HyperfMultiEnv\Config;

/**
 * @Listener
 * Class MultiEnvListener
 */
class MultiEnvListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * process
     *
     * @param  object  $event
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(object $event)
    {
        $env      = env('APP_ENV');
        $env_path = BASE_PATH.'/.env.'.$env;
        if ($event instanceof BootApplication && $env !== null) {
            if (file_exists($env_path) && ApplicationContext::hasContainer()) {
                (ApplicationContext::getContainer())->get(Config::class);
            }
        }
    }
}
<?php
declare(strict_types=1);

namespace Zyimm\HyperfMultiEnv\Listener;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zyimm\HyperfMultiEnv\Config;

/**
 * Class MultiEnvListener
 */
#[Listener]
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
     * @return void
     */
    public function process(object $event):void
    {
        $env      = \Hyperf\Support\env('APP_ENV');
        $env_path = BASE_PATH.'/.env.'.$env;
        if ($env !== null && $event instanceof BootApplication) {
            if (file_exists($env_path) && ApplicationContext::hasContainer()) {
                (ApplicationContext::getContainer())->make(Config::class, [
                    $env,
                    ApplicationContext::getContainer()->get(ConfigInterface::class)
                ])->get();
            }
        }
    }
}
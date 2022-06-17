<?php

declare(strict_types=1);

namespace Zyimm\HyperfMultiEnv;

use Zyimm\HyperfMultiEnv\Listener\MultiEnvListener;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'listener' => [
                MultiEnvListener::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                    'ignore_annotations' => [
                        'mixin',
                    ],
                ],
            ],
            'publish' => [
            ]
        ];
    }
}
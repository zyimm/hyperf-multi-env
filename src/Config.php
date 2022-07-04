<?php

namespace Zyimm\HyperfMultiEnv;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\Adapter;

class Config
{
    private string $env;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    public function get()
    {
        // 加载env
        if (file_exists(BASE_PATH . '/.env.' . $this->env)) {
            $repository = RepositoryBuilder::createWithNoAdapters()
                ->addReader(Adapter\PutenvAdapter::class)
                ->addWriter(Adapter\PutenvAdapter::class)
                ->make();

            Dotenv::create($repository, [BASE_PATH], '.env.' . $this->env)->load();
        }
    }
}
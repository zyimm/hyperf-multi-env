<?php

namespace Zyimm\HyperfMultiEnv;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter;
use Dotenv\Repository\RepositoryBuilder;
use Hyperf\Config\ProviderConfig;
use Hyperf\Contract\ConfigInterface;
use Symfony\Component\Finder\Finder;

class Config
{
    private string $env;

    private ConfigInterface $config;

    private string $configPath = BASE_PATH.'/config/';

    public function __construct(string $env, ConfigInterface $config)
    {
        $this->env = $env;

        $this->config = $config;
    }

    public function get()
    {
        // 加载env
        if (file_exists(BASE_PATH.'/.env.'.$this->env)) {
            $repository = RepositoryBuilder::createWithNoAdapters()
                ->addReader(Adapter\PutenvAdapter::class)
                ->addWriter(Adapter\PutenvAdapter::class)
                ->make();
            Dotenv::create($repository, [BASE_PATH], '.env.'.$this->env)->load();
            $this->update();
        }
    }

    public function update()
    {
        $base       = $this->read($this->configPath.'config.php');
        $server     = $this->read($this->configPath.'server.php');
        $autoload   = $this->scan([$this->configPath.'autoload']);
        $all_config = array_merge_recursive(ProviderConfig::load(), $server, $base, ...$autoload);
        foreach ($all_config as $key => $value) {
            $this->config->set($key, $value);
        }
    }

    private function read(string $config_path): array
    {
        $config = [];
        if (file_exists($config_path) && is_readable($config_path)) {
            $config = require $config_path;
        }
        return is_array($config) ? $config : [];
    }

    private function scan(array $paths)
    {
        $configs = [];
        $finder  = new Finder();
        $finder->files()->in($paths)->name('*.php');
        foreach ($finder as $file) {
            $configs[] = [
                $file->getBasename('.php') => require $file->getRealPath(),
            ];
        }
        return $configs;
    }
}
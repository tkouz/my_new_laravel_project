#!/usr/bin/env php
<?php

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\LazyCollection;

if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__.'/vendor/autoload.php';
} else {
    require __DIR__.'/vendor/autoload.php';
}

class Sail
{
    /**
     * The Composer vendor path.
     *
     * @var string
     */
    protected $vendorPath;

    /**
     * Create a new Sail instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->vendorPath = $this->findVendorPath();
    }

    /**
     * Find the correct Composer vendor path.
     *
     * @return string
     */
    protected function findVendorPath()
    {
        if (file_exists(getcwd().'/vendor')) {
            return getcwd().'/vendor';
        }

        return dirname(__DIR__).'/vendor';
    }

    /**
     * Run the given command.
     *
     * @param  array  $arguments
     * @return void
     */
    public function run(array $arguments)
    {
        $this->ensureDockerIsRunning();

        if ($this->shouldRunComposer($arguments)) {
            $this->runComposerCommand($arguments);

            return;
        }

        $command = $this->buildDockerCommand($arguments);

        passthru($command);
    }

    /**
     * Determine if the command should be run via Composer.
     *
     * @param  array  $arguments
     * @return bool
     */
    protected function shouldRunComposer(array $arguments)
    {
        return count($arguments) > 0 &&
               (str_starts_with($arguments[0], 'composer') ||
                str_starts_with($arguments[0], 'install') ||
                str_starts_with($arguments[0], 'update') ||
                str_starts_with($arguments[0], 'require') ||
                str_starts_with($arguments[0], 'remove'));
    }

    /**
     * Run the Composer command.
     *
     * @param  array  $arguments
     * @return void
     */
    protected function runComposerCommand(array $arguments)
    {
        $command = $this->buildDockerCommand(array_merge(['composer'], $arguments));

        passthru($command);
    }

    /**
     * Build the Docker command.
     *
     * @param  array  $arguments
     * @return string
     */
    protected function buildDockerCommand(array $arguments)
    {
        if (file_exists(getcwd().'/docker-compose.yml')) {
            $command = 'docker-compose exec -u '.posix_getuid().':'.posix_getgid().' laravel.test';
        } elseif (file_exists(getcwd().'/src/docker-compose.yml')) {
            $command = 'docker-compose -f src/docker-compose.yml exec -u '.posix_getuid().':'.posix_getgid().' laravel.test';
        } else {
            fwrite(STDERR, 'Unable to locate docker-compose.yml file.'.PHP_EOL);
            exit(1);
        }

        return $command.' '.implode(' ', array_map(function ($arg) {
            return escapeshellarg($arg);
        }, $arguments));
    }

    /**
     * Ensure Docker is running.
     *
     * @return void
     */
    protected function ensureDockerIsRunning()
    {
        if (! $this->dockerIsRunning()) {
            fwrite(STDERR, 'Docker is not running.'.PHP_EOL);
            exit(1);
        }
    }

    /**
     * Determine if Docker is running.
     *
     * @return bool
     */
    protected function dockerIsRunning()
    {
        return str_contains(shell_exec('docker info 2> /dev/null'), 'Containers');
    }
}

(new Sail())->run(array_slice($argv, 1));

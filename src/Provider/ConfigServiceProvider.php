<?php

namespace NunoPress\Silex\Config\Provider;

use Illuminate\Config\Repository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class ConfigServiceProvider
 *
 * @package NunoPress\Silex\Config\Provider
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['config.path'] = null;
        $app['config.environment'] = null;

        $app['config.merge_factory'] = $app->protect(function (array $old, array $new) {
        	return array_replace_recursive($old, $new);
        });

        $app['config'] = function (Container $app) {
            $files = $this->loadConfigurationFiles($app);

            return new Repository($files);
        };
    }

    /**
     * @param Container $app
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Container $app)
    {
    	if (null === $app['config.path'] or false === is_dir($app['config.path'])) {
    		throw new \Exception("config.path is not defined or the path is invalid");
    	}

        $values = [];

        foreach ($this->getConfigurationFiles($app['config.path']) as $fileKey => $filePath) {
            $values[$fileKey] = $app['config.merge_factory']((array) @$values[$fileKey], require $filePath);
        }

        foreach ($this->getConfigurationFiles($app['config.path'], $app['config.environment']) as $fileKey => $filePath) {
            $values[$fileKey] = $app['config.merge_factory']((array) @$values[$fileKey], require $filePath);
        }

        return $values;
    }

    /**
     * @param string $path
     * @param null|string $environment
     *
     * @return array
     */
    protected function getConfigurationFiles($path, $environment = null)
    {
        if (null !== $environment) {
            $path .= DIRECTORY_SEPARATOR . $environment;
        }

        if (false === is_dir($path)) {
            return [];
        }

        $files = [];

        $phpFiles = Finder::create()->files()->name('*.php')->in($path)->depth(0);

        foreach ($phpFiles as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }
}
<?php

namespace NunoPress\Silex\Config\Application;

use Illuminate\Config\Repository;

/**
 * Class ConfigTrait
 *
 * @package NunoPress\Silex\Config\Application
 */
trait ConfigTrait
{
    /**
     * @see https://github.com/laravel/framework/blob/master/src/Illuminate/Config/Repository.php
     *
     * @param string|array $key
     * @param mixed $default
     *
     * @return mixed|bool
     */
    public function config($key, $default = null)
    {
        /** @var Repository $config */
        $config = $this['config'];

        // Add ability to save data inside of the config service
        if (true === is_array($key)) {
            $config->set($key);

            return true;
        } else {
            return $config->get($key, $default);
        }
    }
}
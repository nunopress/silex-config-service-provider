<?php

namespace NunoPress\Silex\Application;

/**
 * Class ConfigTrait
 * @package NunoPress\Silex\Application
 */
trait ConfigTrait
{
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this['config']->get($key, $default);
    }
}
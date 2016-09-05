<?php

namespace NunoPress\Config\Application;

/**
 * Class ConfigTrait
 * @package NunoPress\Config\Application
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
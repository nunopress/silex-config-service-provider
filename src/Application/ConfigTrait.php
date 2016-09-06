<?php

namespace NunoPress\Pimple\Config\Application;

/**
 * Class ConfigTrait
 * @package NunoPress\Pimple\Config\Application
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
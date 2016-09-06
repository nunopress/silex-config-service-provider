# Config Service Provider

Config Service Provider based on [Illuminate Config](https://github.com/illuminate/config) package for [Silex Microframework](http://silex.sensiolabs.org/) or any [Pimple Container](http://pimple.sensiolabs.org/) project's.

### Parameters

#### config.path

Path defined to find every php files inside for loading.

#### config.environment (optional)

Search before in the defined path and then in the environment path (`config.path/config.environment` format). The service use `array_replace_recursive` for help the developers to change only what you need in the different environment instead to write again all the configuration set.

Here a simple example:

```php
// config/view.php

return [
    'twig' => [
        'path' => realpath(__DIR__ . '/../views'),
        'options' => [
            'debug' => false,
            'cache' => realpath(__DIR__ . '/../../storage/cache/twig')
        ]
    ]
];

// config/development/view.php

return [
    'twig' => [
        'options' => [
            'debug' => true,
            'cache' => false
        ]
    ]
];

// RESULT

[
    'twig' => [
        'path' => realpath(__DIR__ . '/../views'),
        'options' => [
            'debug' => true,
            'cache' => false
        ]
    ]
]
```

#### config.merge_factory (optional)

You can configure your merge method instead to use the default merge factory `array_replace_recursive`:

```php
$app['config.merge_factory'] = $app->share($app->protect('config.merge_factory', function (array $old, array $new) {
    return array_merge($old, $new);
}));
```

### Services

For access to config keys you need to use the `filename` (_without extension_) before every config keys, example:

```php
// config/view.php

return [
    'test' => 'yep'
];

// Access to test key

$app['config']->get('view.test'); // Result: yep
```

#### config

The `Illuminate\Config\Repository` instance. The main way to interact with Config.

### Registering

```php
$app->register(new NunoPress\Config\Provider\ConfigServiceProvider(), [
    'config.path' => __DIR__ . '/config',
    'config.environment' => ($app['debug']) ? 'dev' : 'prod'
]);
```

### Usage

The Config provider provides a `config` service:

```
$app->get('/hello', function () use ($app) {
    $name = $app['config']->get('app.name', 'NunoPress');
    
    return 'Hello ' . $name . '!!';
});
```

> Read the Config [reference](https://laravel.com/api/master/Illuminate/Config/Repository.html) for the Illuminate Config document to learn more about the various Config functions.

### Traits

`NunoPress\Config\Application\ConfigTrait` adds the following shortcuts:

#### config

Access to Config object for retrieve the `key` requested, for the second param you can define a default value.

```php
$name = $app->config('app.name', 'NunoPress');
```

Define this trait in your `Application` class:

```php
class App extends \Silex\Application
{
    use \NunoPress\Config\Application\ConfigTrait;
}

$app = new App();

$name = $app->config('app.name', 'NunoPress');
```

### Customization

You can configure the Config object before using it by extending the `config` service:

```php
$app['config'] = $app->share($app->extend('config', function ($config, $app) {
    // Instead to have separate the config items you can share it in the current container
    $items = $config->all();
    
    foreach ($items as $name => $item) {
        $app[$name] = $item;
    }
    
    return $config;
}));
```
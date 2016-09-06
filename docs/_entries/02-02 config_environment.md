---
title: config.environment
section-id: config-environment
---

Search before in the defined path and then in the environment path (`config.path/config.environment` format). The service use `array_replace_recursive` for help the developers to change only what you need in the different environment instead to write again all the configuration set.

Here a simple example:

{% highlight php %}
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
{% endhighlight %}
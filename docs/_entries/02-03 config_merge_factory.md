---
title: config.merge_factory
section-id: config-merge_factory
---

You can configure your merge method instead to use the default merge factory `array_replace_recursive`:

{% highlight php %}
$app['config.merge_factory'] = $app->share($app->protect('config.merge_factory', function (array $old, array $new) {
    return array_merge($old, $new);
}));
{% endhighlight %}
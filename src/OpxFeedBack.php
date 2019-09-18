<?php

namespace Modules\Opx\FeedBack;

use Illuminate\Support\Facades\Facade;

/**
 * @method  static string|mixed form(string $alias, array $options = [])
 * @method  static string getTemplateFileName(string $name)
 * @method  static array getViewsList()
 * @method  static string name()
 * @method  static string get($key)
 * @method  static string path($path = '')
 * @method  static string trans($key, $parameters = [], $locale = null)
 * @method  static array|string|null  config($key = null)
 * @method  static mixed view($view)
 */
class OpxFeedBack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'opx_feed_back';
    }
}

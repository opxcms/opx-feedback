<?php

namespace Modules\Shop\Categories\Templates;

use Core\Foundation\Template\Template;

/**
 * HELP:
 *
 * ID parameter is shorthand for defining module and field name separated by `::`.
 * [$module, $name] = explode('::', $id, 2);
 * $captionKey = "{$module}::template.section_{$name}";
 *
 * PLACEMENT is shorthand for section and group of field separated by `/`.
 * [$section, $group] = explode('/', $placement);
 *
 * PERMISSIONS is shorthand for read permission and write permission separated by `|`.
 * [$readPermission, $writePermission] = explode('|', $permissions, 2);
 */

return [
    'fields' => [
        // id
        Template::id('id', ''),
        // payload
        Template::html('opx_feed_back::payload', ''),

        // timestamps
        Template::timestampCreatedAt(''),
        Template::timestampDeletedAt(''),
    ],
];

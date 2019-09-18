<?php

namespace Modules\Shop\Categories\Templates;

use Core\Foundation\Template\Template;
use Modules\Opx\FeedBack\OpxFeedBack;

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
    'sections' => [
        Template::section('general'),
        Template::section('opx_feed_back::form'),
    ],
    'groups' => [
        Template::group('common'),
        Template::group('timestamps'),
        Template::group('opx_feed_back::details'),
    ],
    'fields' => [
        // id
        Template::id('id', 'general/common', 'fields.id_info'),
        // alias
        Template::string('alias', 'general/common', '', [], '', 'required|unique:feedback_forms,alias,%id'),
        // name
        Template::string('name', 'general/common', '', [], '', 'required'),
        // enabled
        Template::checkbox('enabled', 'general/common', true),

        // from email
        Template::string('opx_feed_back::from_email', 'general/details', '', [], '', 'required'),
        // from name
        Template::string('opx_feed_back::from_name', 'general/details'),
        // to emails
        Template::string('opx_feed_back::to_emails', 'general/details', '', [], 'opx_feed_back::template.to_emails_info', 'required'),
        // email title
        Template::string('opx_feed_back::email_title', 'general/details', '', [], '', 'required'),

        // form layout
        Template::select('opx_feed_back::form_layout', 'form/details', null, OpxFeedBack::getViewsList(), false, '', 'required'),
        // form title
        Template::string('opx_feed_back::form_title', 'form/details'),
        // form disclaimer
        Template::html('opx_feed_back::form_disclaimer', 'form/details'),
        // form button caption
        Template::string('opx_feed_back::form_button_caption', 'form/details', '', [], '', 'required'),
        // success message
        Template::html('opx_feed_back::success_message', 'form/details', '', [], '', 'required'),
        // error message
        Template::html('opx_feed_back::error_message', 'form/details', '', [], '', 'required'),

        // timestamps
        Template::timestampCreatedAt(),
        Template::timestampUpdatedAt(),
        Template::timestampDeletedAt(),
    ],
];

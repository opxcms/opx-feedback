<?php

return [
    'items' => [
        'feedback' => [
            'caption' => 'opx_feed_back::manage.forms',
            'route' => 'opx_feed_back::feed_back_forms_list',
            'section' => 'system/site',
            'permission' => 'list',
        ],
        'feedback_forms' => [
            'caption' => 'opx_feed_back::manage.forms',
            'route' => 'opx_feed_back::feed_back_records_list',
            'section' => 'system/notifications',
            'permission' => 'notifications',
        ],
    ],

    'routes' => [
        'opx_feed_back::feed_back_forms_list' => [
            'route' => '/forms',
            'loader' => 'manage/api/module/opx_feed_back/feed_back_forms_list',
        ],
        'opx_feed_back::feed_back_forms_add' => [
            'route' => '/forms/add',
            'loader' => 'manage/api/module/opx_feed_back/feed_back_forms_edit/add',
        ],
        'opx_feed_back::feed_back_forms_edit' => [
            'route' => '/forms/edit/:id',
            'loader' => 'manage/api/module/opx_feed_back/feed_back_forms_edit/edit',
        ],
        'opx_feed_back::feed_back_records_list' => [
            'route' => '/forms/records',
            'loader' => 'manage/api/module/opx_feed_back/feed_back_records_list',
        ],
        'opx_feed_back::feed_back_records_edit' => [
            'route' => '/forms/records/:id',
            'loader' => 'manage/api/module/opx_feed_back/feed_back_records_edit/edit',
        ],
    ]
];
<?php

return [
    'reporting' => [
        'email' => [
            'enabled' => env('EMAIL_ENABLED', false),
            'address' => env('BUG_MONITOR_EMAIL', 'bugs@example.com'),
        ],
        'azure_devops' => [
            'enabled' => env('AZURE_DEVOPS_ENABLED', false),
            'organization' => env('AZURE_DEVOPS_ORG'),
            'project' => env('AZURE_DEVOPS_PROJECT'),
            'api_version' => env('AZURE_DEVOPS_API_VERSION', '7.1-preview.3'),
            'token' => env('AZURE_DEVOPS_TOKEN'),
            'area_path' => env('AZURE_DEVOPS_AREA_PATH'),
        ],
        'github' => [
            'enabled' => env('GITHUB_ENABLED', false),
            'owner' => env('GITHUB_OWNER'),
            'repo' => env('GITHUB_REPO'),
            'assignees' => explode(',', env('GITHUB_ASSIGNEES')),
            'labels' => explode(',', env('GITHUB_LABELS')),
            'milestone' => env('GITHUB_MILESTONE'),
            'token' => env('GITHUB_TOKEN'),
        ],
        'trello' => [
            'enabled' => env('TRELLO_ENABLED', false),
            'board_id' => env('TRELLO_BOARD_ID'),
            'list_id' => env('TRELLO_LIST_ID'),
            'token' => env('TRELLO_TOKEN'),
            'key' => env('TRELLO_KEY'),
        ],
    ],
    'automatic_reporting' => env('BUG_COURIER_AUTOMATIC', false),
    'background_reporting' => env('BUG_COURIER_BACKGROUND', true),
    'views_enabled' => env('BUG_COURIER_VIEWS_ENABLED', true),
    'routes' => [
        'prefix' => env('BUG_COURIER_ROUTES_PREFIX', 'bug-courier'),
        'middleware' => env('BUG_COURIER_ROUTES_MIDDLEWARE', 'web'),
    ],
];

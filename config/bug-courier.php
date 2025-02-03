<?php

return [
  'reporting' => [
      'email' => [
          'enabled' => false,
          'address' => env('BUG_MONITOR_EMAIL', 'bugs@example.com'),
      ],
      'azure_devops' => [
          'enabled' => false,
          'organization' => env('AZURE_DEVOPS_ORG'),
          'project' => env('AZURE_DEVOPS_PROJECT'),
          'token' => env('AZURE_DEVOPS_TOKEN'),
          'area_path' => env('AZURE_DEVOPS_AREA_PATH'),
      ],
      'github' => [
          'enabled' => false,
          'repo' => env('GITHUB_REPO'),
          'token' => env('GITHUB_TOKEN'),
      ],
      'trello' => [
          'enabled' => false,
          'board_id' => env('TRELLO_BOARD_ID'),
          'list_id' => env('TRELLO_LIST_ID'),
          'token' => env('TRELLO_TOKEN'),
          'key' => env('TRELLO_KEY'),
      ],
  ],
  'automatic_reporting' => env('BUG_COURIER_AUTOMATIC', false),
  'views_enabled'=>env('BUG_COURIER_VIEWS_ENABLED',true),
  'routes'=>[
      'prefix'=>env('BUG_COURIER_ROUTES_PREFIX','bug-courier'),
      'middleware'=>env('BUG_COURIER_ROUTES_MIDDLEWARE','web'),
  ],
];
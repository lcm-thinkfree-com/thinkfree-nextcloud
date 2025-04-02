<?php
return [
    'routes' => [
		['name' => 'api#index', 'url' => '/api', 'verb' => 'GET'],
        ['name' => 'editor#open', 'url' => '/editor/open', 'verb' => 'GET'],
        ['name' => 'settings#get', 'url' => '/settings/get', 'verb' => 'GET'],
        ['name' => 'settings#set', 'url' => '/settings/set', 'verb' => 'POST'],
        ['name' => 'document#create', 'url' => '/new_document', 'verb' => 'GET']
    ]
];

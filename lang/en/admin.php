<?php

return [
    'create' => 'Add New',
    'save_create' => 'Create',
    'save_edit' => 'Save change',
    'cancel_form' => 'Back to list',
    'task' => [
        'page_name' => 'Task management',
        'page_desc' => 'List your tasks',
        'create_page' => 'Create a new task',
        'edit_page' => 'Edit task',
        'form' => [
            'type' => 'Type of task',
            'name' => 'Title of task',
            'desc' => 'Description for task',
            'duration' => 'Duration (Minutes)',
            'order' => 'Order',
            'valid_amount' => 'Valid amount',
            'valid_radius' => 'Valid radius',
            'status' => 'Status',
            'image' => 'Cover image',
        ],
        'status' => [
            INACTIVE_TASK => 'Draft',
            ACTIVE_TASK => 'Active',
        ],
        'order' => [
            OUT_OF_ORDER => 'Out of order',
            IN_ORDER => 'In order',
        ],
        'type' => [
            CHECKIN => 'Checkin',
            INSTALL_APP => 'Install Mobile App',
            VIDEO_WATCH => 'Video Watch',
            SUBSCRIBE_AND_INTERACT => 'Like / Share / Subcribe',
        ],
    ],
    'location' => [
        'form' => [
            'name' => 'Location name',
            'address' => 'Location address',
            'coordinate' => 'Coordinate: Latitude, Longitude',
            'phone_number' => 'Phone number',
            'open_time' => 'Open time'
        ],
    ],
    'task_created' => 'Task created successfully',
    'guild' => [
        'page_name' => 'Guild management',
        'page_desc' => 'List your guilds',
        'create_page' => 'Create a new guild',
        'edit_page' => 'Edit task',
    ],
    'placeholders' => [
        'valid_amount' => 'Ex: number of places to checkin',
        'phone_number' => 'Ex: 0123456789'
    ]
];

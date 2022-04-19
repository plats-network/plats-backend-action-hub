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
            'name' => 'Title of task',
            'desc' => 'Description for task',
            'duration' => 'Duration (Minutes)',
            'distance' => 'Distance (Kilometer)',
            'reward_amount' => 'Reward amount',
            'status' => 'Status',
            'image' => 'Cover image',
        ],
        'status' => [
            INACTIVE_TASK => 'Draft',
            ACTIVE_TASK => 'Active',
        ],
    ],
];

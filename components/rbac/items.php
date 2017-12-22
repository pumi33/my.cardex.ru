<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Админ панель',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'dashboard',
            'edits',
        ],
    ],
    'superadmin' => [
        'type' => 1,
        'description' => 'СуперАдминистратор',
        'ruleName' => 'userRole',
        'children' => [
            'admin',
            'createManager',
            'changeStatus',
        ],
    ],
    'createManager' => [
        'type' => 2,
        'description' => 'Создание менеджеров',
    ],
    'changeStatus' => [
        'type' => 2,
        'description' => 'Смена статуса',
    ],
    'edits' => [
        'type' => 2,
        'description' => 'Редактирование',
    ],
];

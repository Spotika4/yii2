<?php

return [
    'adminEmail' => 'admin@example.com',
    'rbac' => [
        'permissions' => [
            'backend' => [
                'description' => 'permission_backend_description',
                'data' => [
                    'label' => 'permission_backend_label',
                ],
            ]
        ],
        'roles' => [
            'user' => [
                'description' => 'user_role_description',
                'data' => [
                    'label' => 'user_role_label',
                ],
                'permissions' => [

                ]
            ],
            'author' => [
                'description' => 'author_role_description',
                'data' => [
                    'label' => 'author_role_label',
                ],
                'permissions' => [

                ]
            ],
            'moderator' => [
                'description' => 'moderator_role_description',
                'data' => [
                    'label' => 'moderator_role_label',
                ],
                'permissions' => [

                ]
            ],
            'administrator' => [
                'description' => 'administrator_role_description',
                'data' => [
                    'label' => 'administrator_role_label',
                ],
                'permissions' => [
                    'backend'
                ]
            ]
        ],
        'rules' => [

        ],
        'users' => [
            [
                'username' => 'User',
                'password' => 'User',
                'email' => 'user@user.com',
                'roles' => ['user'],
                'status' => common\models\User::STATUS_ACTIVE,
            ],
            [
                'username' => 'Author',
                'password' => 'Author',
                'email' => 'author@author.com',
                'roles' => ['author'],
                'status' => common\models\User::STATUS_ACTIVE,
            ],
            [
                'username' => 'Moderator',
                'password' => 'Moderator',
                'email' => 'moderator@moderator.com',
                'roles' => ['moderator'],
                'status' => common\models\User::STATUS_ACTIVE,
            ],
            [
                'username' => 'Administrator',
                'password' => 'Administrator',
                'email' => 'administrator@administrator.com',
                'roles' => ['administrator'],
                'status' => common\models\User::STATUS_ACTIVE,
            ]
        ]
    ]
];

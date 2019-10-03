<?php

return [
    'role_structure' => [
        'superadmin' => [
            'dashboard-admin' => 'r',
            'api' => 'c,r,u,d',
            'auth-users' => 'c,r,u,d',
            'auth-roles' => 'c,r,u,d',
            'auth-permissions' => 'c,r,u,d',
            'master-regions' => 'c,r,u,d',
            'master-ruas' => 'c,r,u,d',
            'master-areas' => 'c,r,u,d',
            'master-points' => 'c,r,u,d',
            'master-asset-groups' => 'c,r,u,d',
            'master-assets' => 'c,r,u,d',
            'master-asset-kinds' => 'c,r,u,d',
            'master-matriks' => 'c,r,u,d',
            'monitoring-assets' => 'c,r,u,d',
            'monitoring-performances' => 'c,r,u,d',
            'monitoring-inspections' => 'c,r,u,d',
            'monitoring-complaints' => 'c,r,u,d',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'import',
        'e' => 'export'
    ]
];

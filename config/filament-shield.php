<?php

return [
    'shield_resource' => [
        'should_register_navigation' => true,
        'slug' => 'roles',
        'navigation_sort' => 2,
        'navigation_badge' => false,
        'navigation_group' => true,
        'is_globally_searchable' => false,
        'show_model_path' => false,
        'is_scoped_to_tenant' => true,
    ],

    'auth_provider_model' => [
        'fqcn' => 'App\\Models\\User',
    ],

    'super_admin' => [
        'enabled' => true,
        'name' => 'super_admin',
        'define_via_gate' => false,
        'intercept_gate' => 'before', // after
    ],

    'panel_user' => [
        'enabled' => false,
        'name' => 'panel_user',
    ],

    'admin' => [
        'enabled' => true,
        'name' => 'admin',
    ],

    'user' => [
        'enabled' => true,
        'name' => 'user',
    ],

    'focal' => [
        'enabled' => true,
        'name' => 'focal',
    ],

    'focal_custom' => [
        'enabled' => true,
        'name' => 'focal_custom',
    ],

    'bwc_focal' => [
        'enabled' => true,
        'name' => 'bwc_focal',
    ],

    'permission_prefixes' => [
        'resource' => [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ],

        'page' => 'page',
        'widget' => 'widget',
    ],

    'entities' => [
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => false,
    ],

    'generator' => [
        'option' => 'policies_and_permissions',
        'policy_directory' => 'Policies',
    ],

    'exclude' => [
        'enabled' => true,

        'pages' => [
            'Dashboard',
        ],

        'widgets' => [
            'AccountWidget', 'FilamentInfoWidget',
        ],

        'resources' => [],
    ],

    'discovery' => [
        'discover_all_resources' => true,
        'discover_all_widgets' => false,
        'discover_all_pages' => false,
    ],

    'register_role_policy' => [
        'enabled' => true,
    ],

];
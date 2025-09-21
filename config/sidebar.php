<?php

return [
    'items' => [
        [
            'text' => 'Slider Section',
            'route' => 'admin.dashboard',
            'icon' => 'layout-dashboard',
            'active_on' => ['admin.dashboard', 'admin.slides.*'],
        ],
        [
            'text' => 'About Section',
            'route' => 'admin.about.mission.index',
            'icon' => 'handshake',
            'active_on' => ['admin.about.*'],
        ],
        [
            'text' => 'Your District',
            'route' => 'admin.dagan.index',
            'icon' => 'users',
            'active_on' => ['admin.dagan.*'],
        ],
        [
            'text' => 'Projects',
            'route' => 'admin.projects.index',
            'icon' => 'check-square',
            'active_on' => ['admin.projects.*', 'admin.project-categories.*'],
        ],
        [
            'text' => 'Activities',
            'route' => 'admin.activities.index',
            'icon' => 'badge-check',
            'active_on' => ['admin.activities.*'],
        ],
        [
            'text' => 'Members',
            'route' => 'admin.members.index',
            'icon' => 'users',
            'active_on' => ['admin.members.*', 'admin.committee.*'],
        ],
        [
            'text' => 'Blogs',
            'route' => 'admin.blogs.index',
            'icon' => 'book-open',
            'active_on' => ['admin.blogs.*'],
        ],
        [
            'text' => 'Gallery',
            'route' => 'admin.gallery.index',
            'icon' => 'image',
            'active_on' => ['admin.gallery.*', 'admin.albums.*'],
        ],
        [
            'text' => 'Requests',
            'route' => 'admin.requests.index',
            'icon' => 'mail-check',
            'active_on' => ['admin.requests.*'],
        ],
        [
            'text' => 'Site Info',
            'route' => 'admin.settings',
            'icon' => 'badge-info',
            'active_on' => ['admin.settings'],
        ],
    ],
];

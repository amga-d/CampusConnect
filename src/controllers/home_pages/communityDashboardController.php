<?php
// require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();

// Dummy data for testing
$dashboardData = [
    'community' => [
        'name' => 'Computer Science Club',
        'description' => 'A vibrant community for CS students to collaborate, learn, and grow together. Join us for coding challenges, workshops, and tech discussions!',
        'profile_image' => 'https://cdn-icons-png.flaticon.com/512/2721/2721620.png',
        'banner_image' => 'https://img.freepik.com/free-vector/gradient-technological-background_23-2148884155.jpg',
    ],
    'isAdmin' => true,
    'members' => [
        [
            'name' => 'John Doe',
            'role' => 'Admin',
            'profile_image' => 'https://ui-avatars.com/api/?name=John+Doe'
        ],
        [
            'name' => 'Alice Smith',
            'role' => 'Member',
            'profile_image' => 'https://ui-avatars.com/api/?name=Alice+Smith'
        ],
        [
            'name' => 'Bob Johnson',
            'role' => 'Member',
            'profile_image' => 'https://ui-avatars.com/api/?name=Bob+Johnson'
        ]
    ],
    'activities' => [
        [
            'author_name' => 'John Doe',
            'author_image' => 'https://ui-avatars.com/api/?name=John+Doe',
            'content' => 'Welcome to our new Python Workshop series! Join us every Thursday at 5 PM.',
            'created_at' => '2024-12-09 15:30:00'
        ],
        [
            'author_name' => 'Alice Smith',
            'author_image' => 'https://ui-avatars.com/api/?name=Alice+Smith',
            'content' => 'Just shared the slides from yesterday\'s Machine Learning presentation. Check them out in the resources section!',
            'created_at' => '2024-12-08 14:20:00'
        ],
        [
            'author_name' => 'Bob Johnson',
            'author_image' => 'https://ui-avatars.com/api/?name=Bob+Johnson',
            'content' => 'Looking for team members for the upcoming hackathon. DM if interested!',
            'created_at' => '2024-12-07 09:45:00'
        ]
    ]
];

$error = null;

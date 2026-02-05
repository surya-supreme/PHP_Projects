<?php
// ================================
// CONFIGURATION & DATA
// ================================

// Site Configuration
$site_title = "John Doe Portfolio";
$site_description = "Full Stack Developer & Designer";
$current_year = date('Y');

// Owner Information
$owner = [
    'name' => 'John Doe',
    'title' => 'Full Stack Developer',
    'email' => 'john.doe@example.com',
    'phone' => '+1 (555) 123-4567',
    'location' => 'San Francisco, CA',
    'profile_image' => 'images/profile.svg'  // Easy to change - just replace this image file
];

// Navigation Menu Items
$nav_items = [
    [
        'name' => 'Home',
        'url' => 'index.php',
        'icon' => '🏠'
    ],
    [
        'name' => 'Projects',
        'url' => 'projects.php',
        'icon' => '💼'
    ],
    [
        'name' => 'Contact',
        'url' => 'contact.php',
        'icon' => '📧'
    ]
];

// Skills Data
$skills = [
    [
        'name' => 'PHP',
        'level' => 90,
        'color' => '#777BB4'
    ],
    [
        'name' => 'JavaScript',
        'level' => 85,
        'color' => '#F7DF1E'
    ],
    [
        'name' => 'HTML/CSS',
        'level' => 95,
        'color' => '#E34F26'
    ],
    [
        'name' => 'MySQL',
        'level' => 80,
        'color' => '#4479A1'
    ],
    [
        'name' => 'React',
        'level' => 75,
        'color' => '#61DAFB'
    ],
    [
        'name' => 'Python',
        'level' => 70,
        'color' => '#3776AB'
    ]
];

// Projects Data
$projects = [
    [
        'id' => 1,
        'title' => 'E-Commerce Platform',
        'description' => 'A full-featured online shopping platform with cart, payment integration, and admin dashboard.',
        'technologies' => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
        'image' => '🛒',
        'status' => 'completed',
        'date' => '2024-01'
    ],
    [
        'id' => 2,
        'title' => 'Task Management System',
        'description' => 'Collaborative task manager with real-time updates, team collaboration, and deadline tracking.',
        'technologies' => ['PHP', 'AJAX', 'MySQL', 'CSS3'],
        'image' => '✅',
        'status' => 'completed',
        'date' => '2023-11'
    ],
    [
        'id' => 3,
        'title' => 'Blog CMS',
        'description' => 'Custom content management system for blogging with markdown support and SEO optimization.',
        'technologies' => ['PHP', 'MySQL', 'TinyMCE', 'jQuery'],
        'image' => '📝',
        'status' => 'completed',
        'date' => '2023-09'
    ],
    [
        'id' => 4,
        'title' => 'Weather Dashboard',
        'description' => 'Real-time weather application using external APIs with 7-day forecast and location search.',
        'technologies' => ['PHP', 'API Integration', 'JavaScript'],
        'image' => '🌤️',
        'status' => 'in-progress',
        'date' => '2024-02'
    ],
    [
        'id' => 5,
        'title' => 'Restaurant Reservation',
        'description' => 'Online table booking system with availability calendar and SMS notifications.',
        'technologies' => ['PHP', 'MySQL', 'Calendar.js'],
        'image' => '🍽️',
        'status' => 'in-progress',
        'date' => '2024-01'
    ],
    [
        'id' => 6,
        'title' => 'Portfolio Generator',
        'description' => 'Tool to create custom portfolio websites with drag-and-drop interface and template selection.',
        'technologies' => ['PHP', 'jQuery UI', 'CSS3'],
        'image' => '🎨',
        'status' => 'planning',
        'date' => '2024-03'
    ]
];

// Social Media Links
$social_links = [
    [
        'platform' => 'GitHub',
        'url' => 'https://github.com/johndoe',
        'icon' => '💻'
    ],
    [
        'platform' => 'LinkedIn',
        'url' => 'https://linkedin.com/in/johndoe',
        'icon' => '💼'
    ],
    [
        'platform' => 'Twitter',
        'url' => 'https://twitter.com/johndoe',
        'icon' => '🐦'
    ],
    [
        'platform' => 'Email',
        'url' => 'mailto:john.doe@example.com',
        'icon' => '📧'
    ]
];

// ================================
// HELPER FUNCTIONS
// ================================

// Helper function to get current page
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

// Helper function to check if menu item is active
function isActive($url) {
    return getCurrentPage() === $url ? 'active' : '';
}
?>
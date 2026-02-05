<?php
header("Content-type: text/css");

// Include config for color variables
require_once '../config.php';

// Define modern color scheme
$primary_color = '#2563eb';      // Simple Blue
$secondary_color = '#3b82f6';    // Light Blue
$accent_color = '#1d4ed8';       // Dark Blue
$success_color = '#10b981';      // Green
$warning_color = '#f59e0b';      // Amber
$text_dark = '#1f2937';          // Dark Gray
$text_light = '#6b7280';         // Medium Gray
$background_light = '#f9fafb';   // Very Light Gray
$card_background = '#ffffff';    // White
?>

/* ================================
   RESET AND BASE STYLES
   ================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: <?php echo $text_dark; ?>;
    background: <?php echo $background_light; ?>;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ================================
   HEADER STYLES
   ================================ */

.site-header {
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $secondary_color; ?> 50%, <?php echo $accent_color; ?> 100%);
    color: white;
    padding: 40px 0;
    box-shadow: 0 10px 40px rgba(99, 102, 241, 0.2);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.logo h1 {
    font-size: 2.5em;
    margin-bottom: 8px;
    font-weight: 800;
    letter-spacing: -1px;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
}

.logo .tagline {
    font-size: 1.1em;
    opacity: 0.95;
    font-weight: 300;
    letter-spacing: 0.5px;
}

/* Profile Section Styles */
.profile-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.profile-text {
    display: flex;
    flex-direction: column;
}

/* ================================
   NAVIGATION STYLES
   ================================ */

.main-nav {
    margin-top: 10px;
}

.nav-list {
    display: flex;
    list-style: none;
    gap: 8px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.12);
    font-weight: 500;
}

/* Simple hover color change for navigation */
.nav-link:hover {
    background: rgba(255, 255, 255, 0.25);
}

.nav-link.active {
    background: rgba(255, 255, 255, 0.3);
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.nav-icon {
    font-size: 1.3em;
}

/* ================================
   MAIN CONTENT STYLES
   ================================ */

main {
    min-height: calc(100vh - 300px);
    padding: 60px 0;
}

.page-title {
    text-align: center;
    font-size: 3em;
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 50px;
    font-weight: 800;
    letter-spacing: -2px;
}

.section {
    background: <?php echo $card_background; ?>;
    padding: 50px;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    margin-bottom: 40px;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.section h2 {
    font-size: 2.2em;
    color: <?php echo $text_dark; ?>;
    margin-bottom: 35px;
    padding-bottom: 20px;
    border-bottom: 3px solid transparent;
    background: linear-gradient(to right, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>) left bottom no-repeat;
    background-size: 100% 3px;
    font-weight: 700;
    letter-spacing: -1px;
}

/* ================================
   WELCOME TEXT STYLING
   ================================ */

.welcome-text {
    text-align: center;
    margin-bottom: 40px;
}

.welcome-text p {
    font-size: 1.4em;
    color: <?php echo $text_light; ?>;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

.welcome-text strong {
    color: <?php echo $primary_color; ?>;
    font-weight: 700;
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ================================
   STATS CARDS
   ================================ */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.stat-card {
    text-align: center;
    padding: 35px 25px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
    border-radius: 20px;
    border: 2px solid rgba(99, 102, 241, 0.1);
}

/* Simple hover color change for stat cards */
.stat-card:hover {
    border-color: <?php echo $primary_color; ?>;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
}

.stat-icon {
    font-size: 3.5em;
    margin-bottom: 15px;
}

.stat-value {
    font-size: 2.8em;
    font-weight: 800;
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 15px 0;
    letter-spacing: -1px;
}

.stat-label {
    color: <?php echo $text_light; ?>;
    font-size: 1.1em;
    font-weight: 600;
}

/* ================================
   SKILLS SECTION
   ================================ */

.skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

.skill-item {
    background: <?php echo $background_light; ?>;
    padding: 25px;
    border-radius: 16px;
    border: 2px solid rgba(99, 102, 241, 0.08);
}

/* Simple hover color change for skills */
.skill-item:hover {
    border-color: <?php echo $primary_color; ?>;
    background: white;
}

.skill-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.skill-name {
    font-weight: 700;
    font-size: 1.2em;
    color: <?php echo $text_dark; ?>;
}

.skill-percent {
    color: <?php echo $text_light; ?>;
    font-weight: 600;
    font-size: 1.1em;
}

.progress-bar {
    height: 14px;
    background: #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 10px;
}

/* ================================
   PROJECTS SECTION
   ================================ */

.filter-buttons {
    text-align: center;
    margin-bottom: 40px;
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 12px 28px;
    background: white;
    color: <?php echo $text_dark; ?>;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 1em;
}

.filter-btn:hover {
    border-color: <?php echo $primary_color; ?>;
    color: <?php echo $primary_color; ?>;
    background: rgba(37, 99, 235, 0.05);
}

.filter-btn.active {
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    color: white;
    border-color: <?php echo $primary_color; ?>;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 35px;
}

.project-card {
    background: white;
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 2px solid rgba(99, 102, 241, 0.08);
    border-top: 4px solid <?php echo $primary_color; ?>;
}

/* Simple hover color change for project cards */
.project-card:hover {
    border-color: <?php echo $primary_color; ?>;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
}

.project-icon {
    font-size: 3.5em;
    margin-bottom: 20px;
}

.project-title {
    font-size: 1.6em;
    color: <?php echo $text_dark; ?>;
    margin-bottom: 15px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.project-description {
    color: <?php echo $text_light; ?>;
    margin-bottom: 25px;
    line-height: 1.7;
    font-size: 1.05em;
}

.project-tech {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.tech-tag {
    background: rgba(99, 102, 241, 0.08);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.9em;
    color: <?php echo $primary_color; ?>;
    border: 1px solid rgba(99, 102, 241, 0.2);
    font-weight: 600;
}

/* Simple hover color change for tech tags */
.tech-tag:hover {
    background: <?php echo $primary_color; ?>;
    color: white;
}

.project-status {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 0.88em;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-completed {
    background: #d1fae5;
    color: #065f46;
}

.status-in-progress {
    background: #fef3c7;
    color: #92400e;
}

.status-planning {
    background: #dbeafe;
    color: #1e40af;
}

.project-date {
    margin-top: 15px;
    color: <?php echo $text_light; ?>;
    font-size: 0.95em;
}

.empty-state {
    text-align: center;
    padding: 60px 40px;
    color: <?php echo $text_light; ?>;
}

.empty-state p {
    font-size: 1.3em;
}

/* ================================
   CONTACT FORM STYLES
   ================================ */

.form-group {
    margin-bottom: 30px;
}

.form-group label {
    display: block;
    font-weight: 700;
    margin-bottom: 10px;
    color: <?php echo $text_dark; ?>;
    font-size: 1.05em;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1.05em;
    font-family: inherit;
    background: <?php echo $background_light; ?>;
}

/* Simple hover/focus color change for inputs */
.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: <?php echo $primary_color; ?>;
    background: white;
}

.form-group input.error-border,
.form-group textarea.error-border {
    border-color: #ef4444;
    background: #fef2f2;
}

.form-group textarea {
    resize: vertical;
    min-height: 160px;
}

.btn {
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    color: white;
    padding: 16px 40px;
    border: none;
    border-radius: 30px;
    font-size: 1.15em;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

/* Simple hover color change for button */
.btn:hover {
    background: linear-gradient(135deg, <?php echo $secondary_color; ?>, <?php echo $primary_color; ?>);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
}

.success-message {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    padding: 20px 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 5px solid #10b981;
    font-weight: 600;
}

.error {
    color: #dc2626;
    font-size: 0.95em;
    margin-top: 8px;
    font-weight: 600;
}

.contact-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.contact-info-grid > div {
    padding: 25px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
    border-radius: 16px;
    border: 2px solid rgba(99, 102, 241, 0.1);
}

/* Simple hover color change for contact info cards */
.contact-info-grid > div:hover {
    border-color: <?php echo $primary_color; ?>;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
}

.contact-info-grid h3 {
    font-size: 1.3em;
    margin-bottom: 12px;
    color: <?php echo $text_dark; ?>;
    font-weight: 700;
}

/* ================================
   FOOTER STYLES
   ================================ */

.site-footer {
    background: linear-gradient(135deg, <?php echo $text_dark; ?> 0%, #111827 100%);
    color: white;
    padding: 60px 0 30px;
    margin-top: 80px;
    position: relative;
}

.site-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-section h3 {
    margin-bottom: 20px;
    font-size: 1.4em;
    font-weight: 700;
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-section p {
    margin-bottom: 12px;
    opacity: 0.9;
    font-size: 1.05em;
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    opacity: 0.85;
    display: inline-block;
}

/* Simple hover color change for footer links */
.footer-links a:hover {
    opacity: 1;
    color: <?php echo $accent_color; ?>;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    font-size: 1.5em;
    color: white;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Simple hover color change for social links */
.social-link:hover {
    background: linear-gradient(135deg, <?php echo $primary_color; ?>, <?php echo $accent_color; ?>);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 30px;
    text-align: center;
}

.footer-bottom p {
    opacity: 0.85;
    margin-bottom: 8px;
    font-size: 1.05em;
}

.footer-credit {
    font-size: 1em;
    opacity: 0.7;
}

/* ================================
   RESPONSIVE DESIGN
   ================================ */

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-section {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-image {
        width: 80px;
        height: 80px;
    }
    
    .logo h1 {
        font-size: 2em;
    }
    
    .main-nav {
        width: 100%;
        margin-top: 25px;
    }
    
    .nav-list {
        flex-direction: column;
        width: 100%;
    }
    
    .nav-link {
        justify-content: center;
    }
    
    .page-title {
        font-size: 2.2em;
    }
    
    .section {
        padding: 30px 25px;
    }
    
    .projects-grid {
        grid-template-columns: 1fr;
    }
    
    .skills-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .logo h1 {
        font-size: 1.8em;
    }
    
    .page-title {
        font-size: 1.9em;
    }
    
    .section h2 {
        font-size: 1.7em;
    }
    
    .section {
        padding: 25px 20px;
    }
    
    .welcome-text p {
        font-size: 1.2em;
    }
}

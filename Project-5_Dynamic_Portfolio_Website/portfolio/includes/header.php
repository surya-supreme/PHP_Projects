<?php
// Ensure config is loaded
if (!isset($site_title)) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . $site_title : $site_title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <link rel="stylesheet" href="css/style.php">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="profile-section">
                        <img src="<?php echo $owner['profile_image']; ?>" alt="<?php echo $owner['name']; ?>" class="profile-image">
                        <div class="profile-text">
                            <h1><?php echo $owner['name']; ?></h1>
                            <p class="tagline"><?php echo $owner['title']; ?></p>
                        </div>
                    </div>
                </div>
                <?php include 'includes/nav.php'; ?>
            </div>
        </div>
    </header>
<?php
/**
 * Registration Success Page
 */

session_start();

// Check if user just registered
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['logged_in_user'];
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : "Registration successful!";
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="success-message">
            <h2>✅ <?php echo htmlspecialchars($success_message); ?></h2>
            
            <div style="text-align: left; margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3 style="margin-bottom: 15px; color: #333;">Your Account Details:</h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
            </div>
            
            <p style="margin: 20px 0;">Your account has been created successfully!</p>
            <p style="margin-bottom: 30px; color: #666;">You can now access your dashboard.</p>
            
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="dashboard.php" class="btn-submit" style="text-decoration: none; display: inline-flex; width: auto; padding: 12px 30px;">
                    <span>Go to Dashboard</span>
                </a>
                <a href="logout.php" class="btn-submit" style="text-decoration: none; display: inline-flex; width: auto; padding: 12px 30px; background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);">
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

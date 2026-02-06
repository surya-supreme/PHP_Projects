<?php
/**
 * User Dashboard (Without Database)
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['logged_in_user'];

// Get all registered users count
$total_users = isset($_SESSION['registered_users']) ? count($_SESSION['registered_users']) : 0;

// Display success message if any
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Account</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 800px;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-info-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        }
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="dashboard-header">
            <h2>👤 User Dashboard</h2>
            <p class="subtitle">Welcome to your account</p>
        </div>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>✅ Success!</strong>
            <p><?php echo htmlspecialchars($success); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="user-info-card">
            <h3 style="margin-bottom: 20px; color: #333;">Your Profile Information</h3>
            <div class="info-row">
                <span class="info-label">User ID:</span>
                <span class="info-value">#<?php echo htmlspecialchars($user['id']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Username:</span>
                <span class="info-value"><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Full Name:</span>
                <span class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Users</div>
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Registered in System</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Your Status</div>
                <div class="stat-number">✓</div>
                <div class="stat-label">Active Account</div>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="view_users.php" class="btn-submit" style="text-decoration: none; display: inline-flex; width: auto; flex: 1; justify-content: center;">
                <span>View All Users</span>
            </a>
            <a href="logout.php" class="btn-submit btn-danger" style="text-decoration: none; display: inline-flex; width: auto; flex: 1; justify-content: center;">
                <span>Logout</span>
            </a>
        </div>
        
        <p class="login-link" style="margin-top: 30px;">
            <strong>Note:</strong> This is a demo system using PHP sessions. All data will be lost when the browser session ends.
        </p>
    </div>
</body>
</html>

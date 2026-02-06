<?php
/**
 * View All Registered Users
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit();
}

// Get all registered users
$users = isset($_SESSION['registered_users']) ? $_SESSION['registered_users'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users - User Registration System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .users-container {
            max-width: 900px;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .users-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        .users-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .users-table tr:last-child td {
            border-bottom: none;
        }
        .users-table tr:hover {
            background: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-primary {
            background: #667eea;
            color: white;
        }
        .badge-success {
            background: #27ae60;
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="container users-container">
        <h2>👥 All Registered Users</h2>
        <p class="subtitle">Total Users: <?php echo count($users); ?></p>
        
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <h3>No Users Yet</h3>
                <p>Be the first to register an account!</p>
            </div>
        <?php else: ?>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <span class="badge badge-primary">#<?php echo htmlspecialchars($user['id']); ?></span>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                <?php if ($user['username'] === $_SESSION['logged_in_user']['username']): ?>
                                    <span class="badge badge-success" style="margin-left: 8px;">You</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo !empty($user['gender']) ? htmlspecialchars($user['gender']) : '<em style="color: #999;">Not set</em>'; ?></td>
                            <td style="font-size: 13px; color: #666;">
                                <?php echo date('M d, Y', strtotime($user['registered_at'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div style="margin-top: 30px;">
            <a href="dashboard.php" class="btn-submit" style="text-decoration: none; display: inline-flex; width: auto; padding: 12px 30px;">
                <span>← Back to Dashboard</span>
            </a>
        </div>
        
        <p class="login-link" style="margin-top: 20px;">
            <strong>Note:</strong> This data is stored in PHP sessions and will be cleared when you close your browser.
        </p>
    </div>
</body>
</html>

<?php
/**
 * User Dashboard
 * Displays user profile and account information after login
 */

session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['errors'] = ['Please login to access the dashboard'];
    header("Location: login.php");
    exit();
}

// Get user data from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$full_name = $_SESSION['full_name'];
$user_data = $_SESSION['user_data'];

// Fetch fresh data from file storage
$user = findUser($email);

// If user not found, logout
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($full_name); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .dashboard-header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }
        
        .dashboard-header p {
            margin: 0;
            opacity: 0.9;
        }
        
        .welcome-message {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            margin-bottom: 30px;
        }
        
        .profile-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .profile-card h3 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 24px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }
        
        .info-item label {
            display: block;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .info-item .value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        
        .info-item .value.empty {
            color: #999;
            font-style: italic;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .stat-card .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .logout-btn {
                position: static;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 1000px; position: relative;">
        <a href="../includes/logout.php" class="btn btn-danger logout-btn">
            <span>🚪</span>
            <span>Logout</span>
        </a>
        
        <div class="dashboard-header">
            <h1>👋 Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
            <p>Manage your account and view your profile information</p>
        </div>
        
        <div class="welcome-message">
            <strong>✅ Login Successful!</strong>
            <p style="margin: 5px 0 0 0;">You are now logged in to your account. Here's your profile information:</p>
        </div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">📅</div>
                <div class="label">Member Since</div>
                <div class="value"><?php echo date('M Y', strtotime($user['created_at'])); ?></div>
            </div>
            
            <div class="stat-card">
                <div class="icon">🕐</div>
                <div class="label">Last Login</div>
                <div class="value">
                    <?php 
                    if ($user['last_login']) {
                        echo date('M d, Y', strtotime($user['last_login']));
                    } else {
                        echo 'First Login';
                    }
                    ?>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="icon">✅</div>
                <div class="label">Account Status</div>
                <div class="value" style="color: #28a745;">Active</div>
            </div>
        </div>
        
        <!-- Profile Information -->
        <div class="profile-card">
            <h3>📋 Profile Information</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Username</label>
                    <div class="value">@<?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                
                <div class="info-item">
                    <label>Full Name</label>
                    <div class="value"><?php echo htmlspecialchars($user['full_name']); ?></div>
                </div>
                
                <div class="info-item">
                    <label>Email Address</label>
                    <div class="value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
                
                <div class="info-item">
                    <label>Phone Number</label>
                    <div class="value <?php echo empty($user['phone']) ? 'empty' : ''; ?>">
                        <?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Not provided'; ?>
                    </div>
                </div>
                
                <div class="info-item">
                    <label>Date of Birth</label>
                    <div class="value <?php echo empty($user['date_of_birth']) ? 'empty' : ''; ?>">
                        <?php 
                        if (!empty($user['date_of_birth'])) {
                            echo date('F d, Y', strtotime($user['date_of_birth']));
                            $age = date_diff(date_create($user['date_of_birth']), date_create('today'))->y;
                            echo " ($age years old)";
                        } else {
                            echo 'Not provided';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="info-item">
                    <label>Gender</label>
                    <div class="value <?php echo empty($user['gender']) ? 'empty' : ''; ?>">
                        <?php echo !empty($user['gender']) ? htmlspecialchars($user['gender']) : 'Not specified'; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Account Details -->
        <div class="profile-card">
            <h3>🔐 Account Details</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>User ID</label>
                    <div class="value">#<?php echo htmlspecialchars($user['id']); ?></div>
                </div>
                
                <div class="info-item">
                    <label>Account Created</label>
                    <div class="value"><?php echo date('F d, Y \a\t g:i A', strtotime($user['created_at'])); ?></div>
                </div>
                
                <div class="info-item">
                    <label>Last Login</label>
                    <div class="value">
                        <?php 
                        if ($user['last_login']) {
                            echo date('F d, Y \a\t g:i A', strtotime($user['last_login']));
                        } else {
                            echo 'This is your first login!';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="info-item">
                    <label>Account Type</label>
                    <div class="value">Standard User</div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="edit_profile.php" class="btn btn-primary">
                <span>✏️</span>
                <span>Edit Profile</span>
            </a>
            
            <a href="change_password.php" class="btn btn-secondary">
                <span>🔒</span>
                <span>Change Password</span>
            </a>
            
            <a href="../index.php" class="btn btn-secondary">
                <span>🏠</span>
                <span>Back to Home</span>
            </a>
        </div>
        
        <!-- Security Notice -->
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404;">
                <strong>🔒 Security Reminder:</strong> Always logout when using a shared computer. 
                Never share your password with anyone. If you notice any suspicious activity, 
                change your password immediately.
            </p>
        </div>
    </div>
</body>
</html>

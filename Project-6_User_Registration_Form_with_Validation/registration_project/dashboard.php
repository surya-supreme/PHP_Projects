<?php
/**
 * User Dashboard
 * Displays user information after successful registration or login
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once 'config.php';
require_once 'functions.php';

// Get user details from database
try {
    $conn = getConnection();
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        throw new Exception("User not found");
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    $_SESSION['error'] = "Error loading user data: " . $e->getMessage();
    header("Location: index.php");
    exit();
}

// Format date of birth
$formatted_dob = !empty($user['date_of_birth']) ? date('F d, Y', strtotime($user['date_of_birth'])) : 'Not provided';

// Calculate age if DOB is available
$age = '';
if (!empty($user['date_of_birth'])) {
    $birthDate = new DateTime($user['date_of_birth']);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y . ' years old';
}

// Format created date
$member_since = date('F d, Y', strtotime($user['created_at']));

// Format last login
$last_login = !empty($user['last_login']) ? date('F d, Y g:i A', strtotime($user['last_login'])) : 'First time login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .dashboard-header h1 {
            margin: 0 0 10px 0;
            font-size: 2.5em;
        }
        
        .dashboard-header p {
            margin: 5px 0;
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .welcome-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }
        
        .info-card h3 {
            color: #667eea;
            margin: 0 0 20px 0;
            font-size: 1.3em;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 0.95em;
        }
        
        .info-value {
            color: #333;
            font-size: 1em;
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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
        
        .profile-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            margin-bottom: 15px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .stats-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 8px;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9em;
        }
        
        .empty-value {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="profile-icon">👤</div>
            <h1>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
            <p>@<?php echo htmlspecialchars($user['username']); ?></p>
            <p style="font-size: 0.9em; margin-top: 10px;">
                <span class="badge badge-success">✓ Account Active</span>
            </p>
        </div>

        <!-- Welcome Message -->
        <?php if (isset($_SESSION['success'])): ?>
        <div class="welcome-message">
            <strong>🎉 <?php echo htmlspecialchars($_SESSION['success']); ?></strong>
            <?php unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <!-- Account Statistics -->
        <div class="stats-container">
            <h3 style="margin: 0 0 10px 0; color: #667eea;">📊 Account Overview</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-label">Member Since</div>
                    <div class="stat-number" style="font-size: 1.2em;"><?php echo date('Y', strtotime($user['created_at'])); ?></div>
                    <div class="stat-label"><?php echo $member_since; ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Account Status</div>
                    <div class="stat-number" style="font-size: 1.5em;">✓</div>
                    <div class="stat-label">Active & Verified</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Profile Completion</div>
                    <div class="stat-number">
                        <?php 
                        $completion = 0;
                        if (!empty($user['username'])) $completion += 20;
                        if (!empty($user['email'])) $completion += 20;
                        if (!empty($user['full_name'])) $completion += 20;
                        if (!empty($user['phone'])) $completion += 20;
                        if (!empty($user['date_of_birth'])) $completion += 10;
                        if (!empty($user['gender'])) $completion += 10;
                        echo $completion . '%';
                        ?>
                    </div>
                    <div class="stat-label">
                        <?php if ($completion == 100): ?>
                            Complete
                        <?php else: ?>
                            Add more details
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="cards-grid">
            
            <!-- Personal Information Card -->
            <div class="info-card">
                <h3>👤 Personal Information</h3>
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Username:</span>
                    <span class="info-value">@<?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Gender:</span>
                    <span class="info-value">
                        <?php 
                        if (!empty($user['gender'])) {
                            $gender_icon = $user['gender'] == 'Male' ? '♂️' : ($user['gender'] == 'Female' ? '♀️' : '⚧️');
                            echo $gender_icon . ' ' . htmlspecialchars($user['gender']);
                        } else {
                            echo '<span class="empty-value">Not specified</span>';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date of Birth:</span>
                    <span class="info-value">
                        <?php 
                        if (!empty($user['date_of_birth'])) {
                            echo $formatted_dob . '<br><small>(' . $age . ')</small>';
                        } else {
                            echo '<span class="empty-value">Not provided</span>';
                        }
                        ?>
                    </span>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="info-card">
                <h3>📧 Contact Information</h3>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        <?php 
                        if (!empty($user['phone'])) {
                            echo '📱 ' . htmlspecialchars($user['phone']);
                        } else {
                            echo '<span class="empty-value">Not provided</span>';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Verified:</span>
                    <span class="info-value">
                        <span class="badge badge-success">✓ Email Verified</span>
                    </span>
                </div>
            </div>

            <!-- Account Details Card -->
            <div class="info-card">
                <h3>🔐 Account Details</h3>
                <div class="info-row">
                    <span class="info-label">User ID:</span>
                    <span class="info-value">#<?php echo htmlspecialchars($user['id']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Member Since:</span>
                    <span class="info-value"><?php echo $member_since; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Login:</span>
                    <span class="info-value"><?php echo $last_login; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Account Status:</span>
                    <span class="info-value">
                        <span class="badge badge-success">Active</span>
                    </span>
                </div>
            </div>

            <!-- Security Information Card -->
            <div class="info-card">
                <h3>🛡️ Security & Privacy</h3>
                <div class="info-row">
                    <span class="info-label">Password:</span>
                    <span class="info-value">••••••••</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Two-Factor Auth:</span>
                    <span class="info-value">
                        <span class="badge badge-warning">Not Enabled</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Data Encryption:</span>
                    <span class="info-value">
                        <span class="badge badge-success">✓ Enabled</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Privacy:</span>
                    <span class="info-value">
                        <span class="badge badge-info">Protected</span>
                    </span>
                </div>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="edit_profile.php" class="btn btn-primary">
                ✏️ Edit Profile
            </a>
            <a href="change_password.php" class="btn btn-secondary">
                🔒 Change Password
            </a>
            <a href="logout.php" class="btn btn-danger">
                🚪 Logout
            </a>
        </div>

    </div>

    <script>
        // Show welcome message for 5 seconds
        setTimeout(function() {
            var welcomeMsg = document.querySelector('.welcome-message');
            if (welcomeMsg) {
                welcomeMsg.style.transition = 'opacity 0.5s';
                welcomeMsg.style.opacity = '0';
                setTimeout(function() {
                    welcomeMsg.style.display = 'none';
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>

<?php
/**
 * Registration Success Page
 * Redirects to dashboard after successful registration
 */

session_start();

// Check if user just registered
if (!isset($_SESSION['success']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Redirect to dashboard (success message will be shown there)
header("Location: dashboard.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }
        
        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: white;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-content {
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }
        
        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .info-box ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .info-box li {
            margin: 5px 0;
            color: #666;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-message">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <div class="success-content">
                <h2>✅ Registration Successful!</h2>
                <p style="font-size: 18px; color: #666; margin: 15px 0;">
                    <?php echo htmlspecialchars($message); ?>
                </p>
                
                <div class="info-box">
                    <h4>🎉 What's Next?</h4>
                    <ul>
                        <li>Your account has been created successfully</li>
                        <li>You can now login with your credentials</li>
                        <li>Explore all the features available to you</li>
                        <li>Complete your profile for better experience</li>
                    </ul>
                </div>
                
                <div class="info-box" style="border-left-color: #28a745;">
                    <h4>📧 Email Verification</h4>
                    <p style="margin: 0; color: #666;">
                        A verification email has been sent to your registered email address. 
                        Please check your inbox and verify your account.
                    </p>
                </div>
                
                <div class="button-group">
                    <a href="login.php" class="btn-submit" style="display: inline-block; text-decoration: none; flex: 1; text-align: center;">
                        <span>Proceed to Login</span>
                    </a>
                    <a href="index.php" class="btn-submit btn-secondary" style="display: inline-block; text-decoration: none; flex: 1; text-align: center;">
                        <span>Back to Home</span>
                    </a>
                </div>
                
                <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <p style="margin: 0; color: #856404;">
                        <strong>🔒 Security Tip:</strong> Keep your password safe and never share it with anyone. 
                        Enable two-factor authentication for added security.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

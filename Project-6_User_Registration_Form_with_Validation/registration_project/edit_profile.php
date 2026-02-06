<?php
/**
 * Edit Profile Page
 * Allows users to update their profile information
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
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
    $_SESSION['error'] = "Error loading user data";
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = sanitize($_POST['full_name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $dob = $_POST['dob'] ?? null;
    $gender = $_POST['gender'] ?? null;
    
    $errors = [];
    
    // Validate
    if (empty($full_name)) {
        $errors[] = "Full name is required";
    }
    
    if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits";
    }
    
    // Update if no errors
    if (empty($errors)) {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, date_of_birth = ?, gender = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $full_name, $phone, $dob, $gender, $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Profile updated successfully!";
                header("Location: dashboard.php");
                exit();
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $errors[] = "Error updating profile";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>✏️ Edit Profile</h2>
        <p class="subtitle">Update your personal information</p>
        
        <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="full_name">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['date_of_birth'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="Male" <?php echo ($user['gender'] == 'Male') ? 'checked' : ''; ?>>
                        <span>Male</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="Female" <?php echo ($user['gender'] == 'Female') ? 'checked' : ''; ?>>
                        <span>Female</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="Other" <?php echo ($user['gender'] == 'Other') ? 'checked' : ''; ?>>
                        <span>Other</span>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">Update Profile</button>
            <a href="dashboard.php" class="login-link">← Back to Dashboard</a>
        </form>
    </div>
</body>
</html>

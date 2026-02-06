<?php
/**
 * Helper Functions
 */

function sanitize_input($data) {
    return htmlspecialchars(trim(stripslashes($data)));
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

function validate_password($password) {
    $result = ['valid' => true, 'message' => ''];
    
    if (strlen($password) < 8) {
        $result['valid'] = false;
        $result['message'] = 'Password must be at least 8 characters';
        return $result;
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $result['valid'] = false;
        $result['message'] = 'Password must contain uppercase letter';
        return $result;
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $result['valid'] = false;
        $result['message'] = 'Password must contain lowercase letter';
        return $result;
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $result['valid'] = false;
        $result['message'] = 'Password must contain number';
        return $result;
    }
    
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $result['valid'] = false;
        $result['message'] = 'Password must contain special character';
        return $result;
    }
    
    return $result;
}

function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function redirect($page, $params = []) {
    $url = $page;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    header("Location: $url");
    exit();
}
?>

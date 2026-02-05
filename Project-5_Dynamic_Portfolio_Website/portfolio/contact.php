<?php
// Set page-specific variables
$page_title = "Contact";

// Include configuration
require_once 'config.php';

// Initialize variables
$name = $email = $subject = $message = "";
$errors = [];
$success = false;

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit'])) {
    // Get and sanitize input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate name
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    // Validate subject
    if (empty($subject)) {
        $errors['subject'] = "Subject is required";
    }
    
    // Validate message
    if (empty($message)) {
        $errors['message'] = "Message is required";
    } elseif (strlen($message) < 10) {
        $errors['message'] = "Message must be at least 10 characters";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // Here you would typically:
        // - Send email using mail() function
        // - Save to database
        // - Send to API
        
        // For demo, we'll just set success flag
        $success = true;
        
        // Clear form fields
        $name = $email = $subject = $message = "";
    }
}

// Include header template
include 'includes/header.php';
?>

<main>
    <div class="container">
        <h1 class="page-title">Contact Me</h1>
        
        <div class="section">
            <!-- Success Message -->
            <?php if ($success): ?>
                <div class="success-message">
                    <strong>✅ Success!</strong> Thank you for your message. I'll get back to you soon!
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <form method="POST" action="">
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="<?php echo htmlspecialchars($name); ?>"
                        class="<?php echo isset($errors['name']) ? 'error-border' : ''; ?>">
                    <?php if (isset($errors['name'])): ?>
                        <div class="error"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?php echo htmlspecialchars($email); ?>"
                        class="<?php echo isset($errors['email']) ? 'error-border' : ''; ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Subject Field -->
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input 
                        type="text" 
                        id="subject" 
                        name="subject" 
                        value="<?php echo htmlspecialchars($subject); ?>"
                        class="<?php echo isset($errors['subject']) ? 'error-border' : ''; ?>">
                    <?php if (isset($errors['subject'])): ?>
                        <div class="error"><?php echo $errors['subject']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Message Field -->
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6"
                        class="<?php echo isset($errors['message']) ? 'error-border' : ''; ?>"
                    ><?php echo htmlspecialchars($message); ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <div class="error"><?php echo $errors['message']; ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" name="contact_submit" class="btn">Send Message 📨</button>
            </form>
        </div>
        
        <!-- Contact Information -->
        <div class="section">
            <h2>📍 Get In Touch</h2>
            <div class="contact-info-grid">
                <div>
                    <h3>📧 Email</h3>
                    <p><a href="mailto:<?php echo $owner['email']; ?>" style="color: #667eea; text-decoration: none;"><?php echo $owner['email']; ?></a></p>
                </div>
                <div>
                    <h3>📱 Phone</h3>
                    <p><?php echo $owner['phone']; ?></p>
                </div>
                <div>
                    <h3>📍 Location</h3>
                    <p><?php echo $owner['location']; ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Include footer template
include 'includes/footer.php';
?>


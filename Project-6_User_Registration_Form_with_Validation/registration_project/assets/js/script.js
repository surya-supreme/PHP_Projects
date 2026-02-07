/**
 * Client-Side Form Validation
 * Provides real-time validation and user feedback
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    const form = document.getElementById('registrationForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Clear previous errors
        clearErrors();
        
        // Get form values
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const passwordValue = password.value;
        const confirmPasswordValue = confirmPassword.value;
        const fullName = document.getElementById('full_name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const dob = document.getElementById('dob').value;
        const terms = document.getElementById('terms').checked;
        
        // Validate username
        if (!username) {
            showError('usernameError', 'Username is required');
            isValid = false;
        } else if (username.length < 3 || username.length > 20) {
            showError('usernameError', 'Username must be 3-20 characters');
            isValid = false;
        } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
            showError('usernameError', 'Username can only contain letters, numbers, and underscores');
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showError('emailError', 'Email is required');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showError('emailError', 'Please enter a valid email address');
            isValid = false;
        }
        
        // Validate password
        if (!passwordValue) {
            showError('passwordError', 'Password is required');
            isValid = false;
        } else {
            if (passwordValue.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters');
                isValid = false;
            }
            if (!/[A-Z]/.test(passwordValue)) {
                showError('passwordError', 'Password must contain at least one uppercase letter');
                isValid = false;
            }
            if (!/[a-z]/.test(passwordValue)) {
                showError('passwordError', 'Password must contain at least one lowercase letter');
                isValid = false;
            }
            if (!/[0-9]/.test(passwordValue)) {
                showError('passwordError', 'Password must contain at least one number');
                isValid = false;
            }
        }
        
        // Validate password match
        if (!confirmPasswordValue) {
            showError('confirmPasswordError', 'Please confirm your password');
            isValid = false;
        } else if (passwordValue !== confirmPasswordValue) {
            showError('confirmPasswordError', 'Passwords do not match');
            isValid = false;
        }
        
        // Validate full name
        if (!fullName) {
            showError('fullNameError', 'Full name is required');
            isValid = false;
        } else if (fullName.length < 3) {
            showError('fullNameError', 'Full name must be at least 3 characters');
            isValid = false;
        } else if (!/^[a-zA-Z ]+$/.test(fullName)) {
            showError('fullNameError', 'Full name can only contain letters and spaces');
            isValid = false;
        }
        
        // Validate phone (optional but if provided must be valid)
        if (phone && !/^[0-9]{10}$/.test(phone.replace(/[\s\-\(\)]/g, ''))) {
            showError('phoneError', 'Phone number must be 10 digits');
            isValid = false;
        }
        
        // Validate date of birth (optional but if provided must be valid)
        if (dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 13) {
                showError('dobError', 'You must be at least 13 years old');
                isValid = false;
            }
        }
        
        // Validate terms
        if (!terms) {
            showError('termsError', 'You must agree to the Terms and Conditions');
            isValid = false;
        }
        
        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.error:not(:empty)');
            if (firstError) {
                firstError.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Real-time username validation
    document.getElementById('username').addEventListener('blur', function() {
        const username = this.value.trim();
        const errorElement = document.getElementById('usernameError');
        
        if (!username) {
            return; // Don't show error on empty field
        }
        
        if (username.length < 3 || username.length > 20) {
            showError('usernameError', 'Username must be 3-20 characters');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
            showError('usernameError', 'Only letters, numbers, and underscores allowed');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else {
            errorElement.textContent = '';
            this.classList.remove('invalid');
            this.classList.add('valid');
        }
    });
    
    // Real-time email validation
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        const errorElement = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            return;
        }
        
        if (!emailRegex.test(email)) {
            showError('emailError', 'Please enter a valid email address');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else {
            errorElement.textContent = '';
            this.classList.remove('invalid');
            this.classList.add('valid');
        }
    });
    
    // Password strength indicator
    password.addEventListener('input', function() {
        const passwordValue = this.value;
        const strengthIndicator = document.getElementById('passwordStrength');
        
        if (!passwordValue) {
            strengthIndicator.className = 'password-strength';
            return;
        }
        
        let strength = 0;
        
        // Length check
        if (passwordValue.length >= 8) strength++;
        
        // Uppercase check
        if (/[A-Z]/.test(passwordValue)) strength++;
        
        // Lowercase check
        if (/[a-z]/.test(passwordValue)) strength++;
        
        // Number check
        if (/[0-9]/.test(passwordValue)) strength++;
        
        // Special character check
        if (/[^a-zA-Z0-9]/.test(passwordValue)) strength++;
        
        // Update strength indicator
        strengthIndicator.className = 'password-strength';
        if (strength <= 2) {
            strengthIndicator.classList.add('weak');
        } else if (strength <= 4) {
            strengthIndicator.classList.add('medium');
        } else {
            strengthIndicator.classList.add('strong');
        }
    });
    
    // Real-time password match validation
    confirmPassword.addEventListener('input', function() {
        const passwordValue = password.value;
        const confirmPasswordValue = this.value;
        const errorElement = document.getElementById('confirmPasswordError');
        
        if (!confirmPasswordValue) {
            errorElement.textContent = '';
            this.classList.remove('invalid', 'valid');
            return;
        }
        
        if (passwordValue !== confirmPasswordValue) {
            showError('confirmPasswordError', 'Passwords do not match');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else {
            errorElement.textContent = '';
            this.classList.remove('invalid');
            this.classList.add('valid');
        }
    });
    
    // Real-time full name validation
    document.getElementById('full_name').addEventListener('blur', function() {
        const fullName = this.value.trim();
        const errorElement = document.getElementById('fullNameError');
        
        if (!fullName) {
            return;
        }
        
        if (fullName.length < 3) {
            showError('fullNameError', 'Full name must be at least 3 characters');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else if (!/^[a-zA-Z ]+$/.test(fullName)) {
            showError('fullNameError', 'Full name can only contain letters and spaces');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else {
            errorElement.textContent = '';
            this.classList.remove('invalid');
            this.classList.add('valid');
        }
    });
    
    // Real-time phone validation
    document.getElementById('phone').addEventListener('blur', function() {
        const phone = this.value.trim();
        const errorElement = document.getElementById('phoneError');
        
        if (!phone) {
            errorElement.textContent = '';
            this.classList.remove('invalid', 'valid');
            return;
        }
        
        const cleanPhone = phone.replace(/[\s\-\(\)]/g, '');
        
        if (!/^[0-9]{10}$/.test(cleanPhone)) {
            showError('phoneError', 'Phone number must be 10 digits');
            this.classList.add('invalid');
            this.classList.remove('valid');
        } else {
            errorElement.textContent = '';
            this.classList.remove('invalid');
            this.classList.add('valid');
        }
    });
    
    // Phone number formatting (optional)
    document.getElementById('phone').addEventListener('input', function() {
        let value = this.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        this.value = value;
    });
    
});

/**
 * Display error message
 * @param {string} elementId - ID of error element
 * @param {string} message - Error message to display
 */
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

/**
 * Clear all error messages
 */
function clearErrors() {
    const errors = document.querySelectorAll('.error');
    errors.forEach(error => {
        error.textContent = '';
        error.style.display = 'none';
    });
    
    // Remove validation classes
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.classList.remove('valid', 'invalid');
    });
}

/**
 * Clear specific error
 * @param {string} elementId - ID of error element to clear
 */
function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }
}

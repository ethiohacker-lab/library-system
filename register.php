<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        redirect('admin/dashboard.php');
    } else {
        redirect('member/dashboard.php');
    }
}

$pageTitle = "Register";
include 'includes/header.php';

// Handle registration form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $data = [
        'username' => trim($_POST['username'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'email' => trim($_POST['email'] ?? ''),
        'full_name' => trim($_POST['full_name'] ?? ''),
        'user_type' => $_POST['user_type'] ?? 'student',
        'registration_no' => trim($_POST['registration_no'] ?? ''),
        'department' => trim($_POST['department'] ?? ''),
        'phone' => trim($_POST['phone'] ?? '')
    ];
    
    // Validate passwords match
    if ($data['password'] !== $data['confirm_password']) {
        $error = 'Passwords do not match';
    } else {
        // Remove confirm_password from data array
        unset($data['confirm_password']);
        
        // Register user
        $result = $auth->register($data);
        
        if ($result['success']) {
            $success = 'Registration successful! You can now login.';
            // Clear form data
            $data = array_fill_keys(array_keys($data), '');
        } else {
            $error = $result['message'];
        }
    }
}

// Get departments for dropdown
$departments = [
    'Computer Science',
    'Information Technology',
    'Electronics & Communication',
    'Mechanical Engineering',
    'Civil Engineering',
    'Electrical Engineering',
    'Physics',
    'Chemistry',
    'Mathematics',
    'English',
    'Management Studies',
    'Commerce'
];
?>

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Account</h3>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <div class="mt-2">
                                <a href="login.php" class="btn btn-success btn-sm">
                                    <i class="fas fa-sign-in-alt me-1"></i>Go to Login
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo isset($data['full_name']) ? htmlspecialchars($data['full_name']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">Please enter your full name.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo isset($data['username']) ? htmlspecialchars($data['username']) : ''; ?>" 
                                       required minlength="3">
                                <div class="invalid-feedback">Username must be at least 3 characters long.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo isset($data['phone']) ? htmlspecialchars($data['phone']) : ''; ?>">
                            </div>
                            
                            <!-- Passwords -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                            
                            <!-- University Information -->
                            <div class="col-md-6 mb-3">
                                <label for="user_type" class="form-label">User Type *</label>
                                <select class="form-select" id="user_type" name="user_type" required>
                                    <option value="student" <?php echo (isset($data['user_type']) && $data['user_type'] == 'student') ? 'selected' : ''; ?>>Student</option>
                                    <option value="faculty" <?php echo (isset($data['user_type']) && $data['user_type'] == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="registration_no" class="form-label">Registration Number *</label>
                                <input type="text" class="form-control" id="registration_no" name="registration_no" 
                                       value="<?php echo isset($data['registration_no']) ? htmlspecialchars($data['registration_no']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">Please enter your registration number.</div>
                            </div>
                            
                            <div class="col-md-12 mb-4">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" name="department">
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?php echo $dept; ?>" 
                                            <?php echo (isset($data['department']) && $data['department'] == $dept) ? 'selected' : ''; ?>>
                                            <?php echo $dept; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Terms and Submit -->
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                    </label>
                                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                    <a href="login.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Already have an account? Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Library Membership Agreement</h6>
                <p>By registering for a library account, you agree to:</p>
                <ol>
                    <li>Use the library resources responsibly and ethically</li>
                    <li>Return borrowed materials on or before the due date</li>
                    <li>Pay any applicable fines for overdue materials</li>
                    <li>Report lost or damaged materials immediately</li>
                    <li>Keep your account information up to date</li>
                    <li>Not share your account credentials with others</li>
                    <li>Follow all library rules and regulations</li>
                </ol>
                <p>The library reserves the right to suspend or terminate accounts for violations of these terms.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(inputId, buttonId) {
        const button = document.getElementById(buttonId);
        button.addEventListener('click', function() {
            const input = document.getElementById(inputId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
    
    togglePassword('password', 'togglePassword1');
    togglePassword('confirm_password', 'togglePassword2');
    
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strength = document.getElementById('password-strength');
        
        if (!strength) {
            const div = document.createElement('div');
            div.id = 'password-strength';
            div.className = 'mt-1';
            this.parentNode.appendChild(div);
        }
        
        let strengthText = '';
        let strengthClass = '';
        
        if (password.length === 0) {
            strengthText = '';
        } else if (password.length < 6) {
            strengthText = 'Weak';
            strengthClass = 'text-danger';
        } else if (password.length < 10) {
            strengthText = 'Medium';
            strengthClass = 'text-warning';
        } else {
            strengthText = 'Strong';
            strengthClass = 'text-success';
        }
        
        document.getElementById('password-strength').innerHTML = 
            `<small class="${strengthClass}">${strengthText}</small>`;
    });
</script>

<?php include 'includes/footer.php'; ?>
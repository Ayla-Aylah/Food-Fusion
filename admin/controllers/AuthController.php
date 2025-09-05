<?php
namespace AdminController;

use AdminModel\Admin;

class AuthController {

    public function adminRegisterForm() {
        include_once(__DIR__ . '/../views/auth/adminRegister.php');
    }
 public function adminRegisterProcess()
{
    $Admin = new Admin();

    // Step 1: Sanitize input data
    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'username'   => trim($_POST['username'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'password'   => $_POST['password'] ?? ''
    ];
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $_SESSION['old'] = $data + ['confirm_password' => $confirmPassword];

    $errors = [];

    // Step 2: Required field & uniqueness validation
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        } elseif (in_array($key, ['email', 'username']) && $Admin->findByUsernameOrEmail($value)) {
            $errors[$key] = ucfirst($key) . ' already exists.';
        }
    }

    // Step 3: Email format check
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Step 4: Username length check
    if (!empty($data['username']) && strlen($data['username']) < 3) {
        $errors['username'] = 'Username must be at least 3 characters.';
    }

    // Step 5: Password strength checks
    if (strlen($data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    } elseif (!preg_match('/[A-Z]/', $data['password'])) {
        $errors['password'] = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[0-9]/', $data['password'])) {
        $errors['password'] = 'Password must contain at least one number.';
    } elseif (!preg_match('/[\W]/', $data['password'])) {
        $errors['password'] = 'Password must contain at least one special character.';
    }

    // Step 6: Confirm password check
    if (empty($confirmPassword)) {
        $errors['confirm_password'] = 'Please confirm your password.';
    } elseif ($data['password'] !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // Step 7: Terms agreement check
    if (empty($_POST['terms'])) {
        $errors['terms'] = 'You must agree to the terms and conditions.';
    }

    // Step 8: Handle errors or proceed with registration
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: /foodfusion/admin/adminRegister');
        exit;
    }

    // Step 9: Register admin
    if ($Admin->register($data)) {
        $_SESSION['success'] = 'Admin registered successfully.';
        header('Location: /foodfusion/admin/adminLogin');
        exit;
    } else {
        $_SESSION['error'] = ['registerFailed' => 'Registration failed. Please try again.'];
        header('Location: /foodfusion/admin/adminRegister');
        exit;
    }
}


    public function adminLoginForm() {
        include_once(__DIR__ . '/../views/auth/adminLogin.php');
    }
    
    public function adminLoginProcess() {
    $Admin = new Admin();
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];
    $_SESSION['old'] = ['identifier' => $identifier];

    if (empty($identifier)) {
        $errors['identifier'] = 'Username or email is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: /foodfusion/admin/adminLogin');
        exit;
    }

    // Lockout check
    $maxLoginAttempt = 3;
    $lockoutMinutes = 3; 
    $lockoutTime = $lockoutMinutes * 60;

    $failedAttempts = $Admin->countRecentFailedAttempts($identifier, $lockoutMinutes);

    if ($failedAttempts >= $maxLoginAttempt) {
        $lastAttempt = $Admin->getLastFailedAttemptTime($identifier);
        if ($lastAttempt) {
            $lastTimestamp = strtotime($lastAttempt);
            $elapsed = ($lastTimestamp === false) ? PHP_INT_MAX : time() - $lastTimestamp;
            if ($elapsed < $lockoutTime) {
                $remainingSeconds = $lockoutTime - $elapsed;
                $remainingMinutes = floor($remainingSeconds / 60);
                $remainingSecs = $remainingSeconds % 60;

                $_SESSION['error'] = [
                    'login' => "Too many login attempts. Try again in {$remainingMinutes} minute(s) and {$remainingSecs} second(s)."
                ];
                header('Location: /foodfusion/admin/adminLogin');
                exit;
            }
        }
    }

    // Fetch admin user
    $admin = $Admin->findByUsernameOrEmail($identifier);
    $adminid = $admin['id'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'];

    // Invalid user or password
    if (!$admin || !password_verify($password, $admin['password'])) {
        $Admin->recordLoginAttempt($adminid, $identifier, $ip, false);
        $errors['identifier'] = 'Invalid Username / Email';
        $errors['password'] = 'Invalid credentials.';
        $_SESSION['error'] = $errors;
        header('Location: /foodfusion/admin/adminLogin');
        exit;
    }

    // Successful login
    $Admin->recordLoginAttempt($adminid, $identifier, $ip, true);
    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin'] = [
        'id' => $admin['id'],
        'username' => $admin['username'],
        'email' => $admin['email'],
        'role'=> $admin['role']
    ];

    header('Location: /foodfusion/admin/eventList');
    exit;
}

}
?>
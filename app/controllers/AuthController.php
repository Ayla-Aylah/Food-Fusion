<?php
namespace Controller;

use Model\User;

class AuthController {
    public function registerForm() {
         if (!isset($_SESSION)) {
            session_start();
        }
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        include_once(__DIR__ . '/../views/auth/register.php');
    }

    public function registerProcess() {
        $user = new User();

        $formType = $_POST['source'];
        $isJoinUs = ($formType === 'joinus');
        
        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name'  => trim($_POST['last_name'] ?? ''),
            'username'   => trim($_POST['username'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'password'   => $_POST['password'] ?? ''
        ];

        $password = $data['password'];
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $_SESSION['old'] = $data + ['confirm_password' => $confirmPassword];

        $errors = [];

        // Required field validation
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
                continue;
            }

            if (in_array($key, ['email', 'username']) && $user->exists($key, $value)) {
                $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' already exists.';
            }
        }

        // Email format validation
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        // Username length validation
        if (!empty($data['username']) && strlen($data['username']) < 3) {
            $errors['username'] = 'Username must be at least 3 characters.';
        }

        // Password validation
        if (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors['password'] = 'Password must contain at least one uppercase letter.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors['password'] = 'Password must contain at least one number.';
        } elseif (!preg_match('/[\W]/', $password)) {
            $errors['password'] = 'Password must contain at least one special character.';
        }

        // Confirm password validation
        if (empty($confirmPassword)) {
            $errors['confirm_password'] = 'Please confirm your password.';
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        // Terms agreement
        if (empty($_POST['terms'])) {
            $errors['terms'] = 'You must agree to the terms and conditions.';
        }

        $recaptchaSecret = '6LeiYnMrAAAAABebA9WxicO0kBYgBswRhzNdf7jx';
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

        if (empty($recaptchaResponse)) {
            $errors['recaptcha'] = 'Please complete the reCAPTCHA.';
        } else {
            $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
            $response = file_get_contents(
                $verifyUrl . '?secret=' . urlencode($recaptchaSecret) . '&response=' . urlencode($recaptchaResponse)
            );
            $responseData = json_decode($response, true);

            if (!$responseData['success']) {
                $errors['recaptcha'] = 'reCAPTCHA verification failed. Please try again.';
            }
        }
        if (!empty($errors)) {
            if ($isJoinUs) {
                
                $_SESSION['join_errors'] = $errors;
                $_SESSION['join_old'] = $data;
                $_SESSION['from_cta'] = true; 
                
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
                header('Location: /foodfusion/public/');
                exit;
            } else {
                $_SESSION['error'] = $errors;
                header('Location: /foodfusion/public/register');
                exit;
            }

        }

        // Attempt to register the user
        if ($user->register($data)) {
            if ($isJoinUs) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Registration successful!']);
                
                header('Location: foodfusion/public/login');
                exit;
            } else {
                header('Location: foodfusion/public/login');
                exit;
            }

        } else {
            if ($isJoinUs) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => ['registerFailed' => 'Registration failed. Please try again.']]);
                exit;
            } else {
                $_SESSION['error'] = ['registerFailed' => 'Registration failed. Please try again.'];
                header('Location: /foodfusion/public/register');
                exit;
            }

        }
    }

    public function loginForm() {
         if (!isset($_SESSION)) {
            session_start();
        }
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        
        include_once(__DIR__ . '/../views/auth/login.php');
    }
    
    public function loginProcess() {
    $userModel = new User();
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $errors = [];
    $_SESSION['old'] = ['identifier' => $identifier];

    // Validation
    if (empty($identifier)) $errors['identifier'] = 'Username or email is required.';
    if (empty($password)) $errors['password'] = 'Password is required.';
     $recaptchaSecret = '6LeiYnMrAAAAABebA9WxicO0kBYgBswRhzNdf7jx';
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

        if (empty($recaptchaResponse)) {
            $errors['recaptcha'] = 'Please complete the reCAPTCHA.';
        } else {
            $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
            $response = file_get_contents(
                $verifyUrl . '?secret=' . urlencode($recaptchaSecret) . '&response=' . urlencode($recaptchaResponse)
            );
            $responseData = json_decode($response, true);

            if (!$responseData['success']) {
                $errors['recaptcha'] = 'reCAPTCHA verification failed. Please try again.';
            }
        }
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: /foodfusion/public/login');
        exit;
    }

    // Lockout check
    $maxLoginAttempt = 3;
    $lockoutMinutes = 3;
    $lockoutTime = $lockoutMinutes * 60;
    $failedAttempts = $userModel->countRecentFailedAttempts($identifier, $lockoutMinutes);

    if ($failedAttempts >= $maxLoginAttempt) {
        $lastAttempt = $userModel->getLastFailedAttemptTime($identifier);
        if ($lastAttempt) {
            $lastTimestamp = strtotime($lastAttempt);
            $elapsed = time() - $lastTimestamp;
            if ($elapsed < $lockoutTime) {
                $remainingSeconds = $lockoutTime - $elapsed;
                $remainingMinutes = floor($remainingSeconds / 60);
                $remainingSecs = $remainingSeconds % 60;

                $_SESSION['error'] = [
                    'login' => "Too many login attempts. Try again in {$remainingMinutes}m {$remainingSecs}s."
                ];
                header('Location: /foodfusion/public/login');
                exit;
            }
        }
    }

    // Try finding user
    $user = $userModel->findByUsernameOrEmail($identifier);
    if (!$user) {
        $userModel->recordLoginAttempt(null, $identifier, $ip, false);
        $_SESSION['error'] = ['identifier' => 'User not found.'];
        header('Location: /foodfusion/public/login');
        exit;
    }

    // Check password
    if (!password_verify($password, $user['password'])) {
        $userModel->recordLoginAttempt($user['id'], $identifier, $ip, false);
        $_SESSION['error'] = ['password' => 'Incorrect password.'];
        header('Location: /foodfusion/public/login');
        exit;
    }

    // Success
    $userModel->recordLoginAttempt($user['id'], $identifier, $ip, true);
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
    $_SESSION['isLoggedIn'] = true;
    header('Location: /foodfusion/public/');
    exit;
}

}
?>
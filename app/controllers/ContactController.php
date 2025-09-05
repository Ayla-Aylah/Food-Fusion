<?php
namespace Controller;

use Model\ContactUs;
use Model\User;

class ContactController {
public function contactUs() {
    $userModel = new User();
    if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        $userId = $_SESSION['user']['id'];
        $user = $userModel->findById($userId);
    } else {
        $user = null;
    }

    $userData = [
        'user' => $user,
        'user_profile' => $user['profile_image'] ?? null
    ];

    extract($userData);
    include_once(__DIR__ . "/../views/pages/contactUs.php");
}

    public function contactUsProcess()
    {
        $contact = new contactUs();
        $data = [
            'full_name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'messageType' => trim($_POST['messageType']),
            'message' => trim($_POST['message'])
        ];

        $errors = [];

        foreach ($data as $key => $value) {
            if (empty($value)) {
                $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
                continue;
            }
        }
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
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
                $_SESSION['error'] = $errors;
                $_SESSION['old'] = $data;
                header('Location: /foodfusion/public/contactUs');
                exit;
        }
        
          if ($contact->storeContact($data)) {
                header("Location: /foodfusion/public/contactUs?success=" . urlencode("Message sent successfully!"));
                exit;
            } else {
                $_SESSION['error'] = ['contactFailed' => 'Contact failed. Please try again.'];
                header('Location: /foodfusion/public/contactUs');
                exit;
            }

        }
    }
    

?>
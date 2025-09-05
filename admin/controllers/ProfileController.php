<?php

namespace AdminController;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use AdminModel\Admin;
use Model\User;
use Model\CookBook;

Class ProfileController{
  
    public function viewProfile() {
    $admin = $_SESSION['admin'];



    $id = $_SESSION['admin']['id'];
    $adminModel = new Admin();
    $admin = $adminModel->findById($id);
    $adminSession = $_SESSION['admin'] ?? null;
    
    if (!$admin || ($adminSession['is_deleted'] ?? 0) == 1) {
        // User no longer exists or is deleted — destroy session and redirect
        session_unset();
        session_destroy();
        header("Location: /foodfusion/admin/adminLogin");
        exit;
    }
    
    include_once __DIR__ . '/../views/pages/profile.php';
    }
public function delete() {
    $model = new Admin();
    $id = $_POST['admin_id'];
    $model->deleteUsersById($id);
    session_unset();
    session_destroy();
    header("Location: /foodfusion/admin/adminLogin");
    exit;
}
public function updateProfile() {
    if (!isset($_SESSION['admin'])) {
        header('Location: /foodfusion/admin/login');
        exit;
    }

    $adminID = $_SESSION['admin']['id'];
    $adminModel = new Admin();
    $currentUser = $adminModel->findById($adminID);

    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'username'   => trim($_POST['username'] ?? ''),
        'email'      => trim($_POST['email'] ?? '')
    ];

    $_SESSION['old'] = $data;
    $errors = [];
    
       if (!empty($_FILES['profile_image']['name'])) {
        $uploadResult = $adminModel->uploadProfileImage('profile_image');

        if (isset($uploadResult['error'])) {
            $errors['profile_image'] = $uploadResult['error'];
        } else {
            $data['profile_image'] = $uploadResult['path'];
        }
    } else {
        $data['profile_image'] = $currentUser['profile_image'];
    }
    
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: /foodfusion/admin/profile');
        exit;
    }

    // Update only changed fields
    $fieldsToUpdate = [];
    foreach ($data as $key => $value) {
        if ($value !== $currentUser[$key]) {
            $fieldsToUpdate[$key] = $value;
        }
    }
     if (!empty($fieldsToUpdate)) {
        $success = $adminModel->updateProfile($adminID, $fieldsToUpdate);

        if ($success) {
            $_SESSION['admin'] = $adminModel->findById($adminID);
            $_SESSION['success'] = 'Profile updated successfully.';
        } else {
            $_SESSION['error'] = ['Failed to update profile.'];
        }
    } else {
        $_SESSION['success'] = 'No changes made.';
    }

    unset($_SESSION['old']);
    header('Location: /foodfusion/admin/profile');
    exit;
}

public function logout(){
    session_start();
    session_unset();
    session_destroy();
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
}

?>
<?php

namespace Controller;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Model\User;
use Model\CookBook;

Class ProfileController{
  
    public function viewProfile() {
    $user = $_SESSION['user'];
    if ( !isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] === 'admin') {
        header('Location: /foodfusion/public/login');
        exit;
    }
    $userId = $_SESSION['user']['id'];
    $userModel = new User();
    $user = $userModel->findById($userId);
    $userSession = $_SESSION['user'] ?? null;
    $cookbook = new CookBook();
    $recipes = $cookbook->getRecipesByUserID($userId);
    $favourites = $cookbook->getFavByUserID($userId);
    $tips = $cookbook->gettipsbyid($userId);
    $experiences = $cookbook->getexpbyid($userId);
    $totalRecipe = $cookbook->getTotalRecipesByUserID($userId);
    if (!$user || ($userSession['is_deleted'] ?? 0) == 1) {
        // User no longer exists or is deleted — destroy session and redirect
        session_unset();
        session_destroy();
        header("Location: /foodfusion/public/login");
        exit;
    }
    
    include_once __DIR__ . '/../views/pages/profile.php';
    }
public function delete() {
    $model = new User();
    $id = $_POST['id'];
    $model->deleteById($id);
    header("Location: /foodfusion/public/profile");
    exit;
}
public function updateProfile() {
    if (!isset($_SESSION['user'])) {
        header('Location: /foodfusion/public/login');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $userModel = new User();
    $currentUser = $userModel->findById($userId);

    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'username'   => trim($_POST['username'] ?? ''),
        'email'      => trim($_POST['email'] ?? '')
    ];

    $_SESSION['old'] = $data;
    $errors = [];
    
       if (!empty($_FILES['profile_image']['name'])) {
        $uploadResult = $userModel->uploadProfileImage('profile_image');

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
        header('Location: /foodfusion/public/profile');
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
        $success = $userModel->updateProfile($userId, $fieldsToUpdate);

        if ($success) {
            $_SESSION['user'] = $userModel->findById($userId);
            $_SESSION['success'] = 'Profile updated successfully.';
        } else {
            $_SESSION['error'] = ['Failed to update profile.'];
        }
    } else {
        $_SESSION['success'] = 'No changes made.';
    }
    unset($_SESSION['old']);
    header('Location: /foodfusion/public/profile');
    exit;
}

public function logout(){
    session_start();
    session_unset();
    session_destroy();
    header('Location: /foodfusion/public/login');
    exit;
}
}

?>
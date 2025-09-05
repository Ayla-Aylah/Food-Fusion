<?php
namespace AdminController;

use AdminModel\Admin;
use Model\User;

class UserController {
    public function userList() {
        $Admin = new Admin();
        $users = $Admin->getAllUsers();
        include_once __DIR__ . '/../views/pages/userList.php';
    }
    
   public function deleteUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        $adminModel = new Admin();

        $adminModel->deleteUsersById($userId);

        $_SESSION['success'] = 'User deleted successfully.';
        header('Location: /foodfusion/admin/userList');
        exit;
    } else {
        $_SESSION['error'] = 'Invalid request.';
        header('Location: /foodfusion/admin/userList');
        exit;
    }
}


}
?>
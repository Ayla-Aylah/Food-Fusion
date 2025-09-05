<?php
namespace AdminController;
use AdminModel\Team;

class TeamController {
    public function list() {
        $model = new Team();
        $members = $model->getAll();
        include_once __DIR__ . '/../views/pages/TeamList.php';
    }

    public function createForm() {
        include_once __DIR__ . '/../views/pages/createTeamMember.php';
    }

    public function createProcess() {
        $model = new Team();
        $photoPath = $this->uploadPhoto('photo');
        
        $data = [
            'name' => $_POST['name'],
            'position' => $_POST['position'],
            'photo' => $photoPath,
            'email' => $_POST['email']
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

        if(!empty($errors)) {
            $_SESSION['old'] = $data;
            $_SESSION['error'] = $errors;
            header('Location: /foodfusion/admin/createTeamMember');
            exit;
        }

        $model->add($data);
        header("Location: /foodfusion/admin/teamList");
        exit;
    }

    
public function delete($id) {
    $model = new Team();
    $model->delete($id);
    header("Location: /foodfusion/admin/team");
    exit;
}


    public function edit() {
        $teamModel = new Team();
        $id = $_GET['id'] ?? null;
        $member = $teamModel->getById($id);

        if (!$member) {
            header("Location: /foodfusion/admin/teamList");
            exit;
        }

        include_once __DIR__ . '/../views/pages/editTeamMember.php';
    }
public function editProcess() {

    $id = $_POST['id'] ?? null;
    if (!$id || !is_numeric($id)) {
        $_SESSION['error'] = "Invalid team member ID.";
        header("Location: /foodfusion/admin/teamList");
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $errors = [];

    if (empty($name)) $errors['name'] = "Name is required.";
    if (empty($position)) $errors['position'] = "Position is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email is required.";

    // Handle profile photo upload
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
            $errors['photo'] = "Only JPG, PNG, GIF files allowed.";
        } else {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/Team/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $photo_path = "uploads/Team/" . $filename;
            } else {
                $errors['photo'] = "Failed to upload photo.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: /foodfusion/admin/editTeamMember?id=" . $id);
        exit;
    }

    $dataToUpdate = [
        'name' => $name,
        'position' => $position,
        'email' => $email,
    ];

    if ($photo_path !== null) {
        $dataToUpdate['photo'] = $photo_path;
    }

    $model = new \AdminModel\Team();
    $updated = $model->update($id, $dataToUpdate);

    if ($updated) {
        $_SESSION['success'] = "Team member updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update team member.";
    }

    header("Location: /foodfusion/admin/teamList");
    exit;
}


    public function uploadPhoto($field) {
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/Team/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $fileName = uniqid() . '_' . basename($_FILES[$field]['name']);
        $target = $dir . $fileName;
        move_uploaded_file($_FILES[$field]['tmp_name'], $target);
        return "uploads/Team/" . $fileName;
    }
      
   public function deleteMember() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $Id = $_POST['id'];
        
        $Team = new Team();
        // if ($_SESSION['user']['id'] == $userId) {
        //     $_SESSION['error'] = "You can't delete your own account.";
        //     header('Location: /foodfusion/admin/userList');
        //     exit;
        // }

        $Team->deleteMemberByID($Id);

        $_SESSION['success'] = 'Member deleted successfully.';
        header('Location: /foodfusion/admin/teamList');
        exit;
    } else {
        $_SESSION['error'] = 'Invalid request.';
        header('Location: /foodfusion/admin/teamList');
        exit;
    }
}
}

?>
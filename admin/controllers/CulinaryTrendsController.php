<?php
namespace AdminController;
use AdminModel\Admin;
use AdminModel\Trend;

class CulinaryTrendsController {
    public function editCulinaryTrend() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: /foodfusion/admin/culinaryTrends');
        exit;
    }

    $model = new Trend();
    $trend = $model->getById($id);
    if (!$trend) {
        header('Location: /foodfusion/admin/culinaryTrends');
        exit;
    }
    include __DIR__ . '/../views/pages/editTrend.php';
}

    public function delete() {
        $model = new Trend();
        $id = $_POST['id'];
        $model->deleteTrend($id);
        header("Location: /foodfusion/admin/culinaryTrends");
        exit;
    }

public function editCulinaryTrendProcess() {
    $id = $_POST['id'] ?? null;
    $title = $_POST['trend_title'];
    $description = $_POST['trend_description'];
    $createdAt = date('Y-m-d H:i:s');

    if (empty($id) || empty($title) || empty($description)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
        header("Location: /foodfusion/admin/editCulinaryTrend?id=$id");
        exit;
    }

    $model = new Trend();
    $trend = $model->getById($id);

    $imagePath = $trend['trend_image'];

    if (!empty($_FILES['trend_image']['name'])) {
        $uploadDir = 'uploads/trends/';
        $fileName = uniqid() . '_' . basename($_FILES['trend_image']['name']);
        $targetFile = $uploadDir . $fileName;

        move_uploaded_file($_FILES['trend_image']['tmp_name'], __DIR__ . '/../../public/' . $targetFile);
        $imagePath = $targetFile;
    }

    $model->update($id, $title, $description, $imagePath, $createdAt);

    $_SESSION['success'] = 'Culinary Trend updated successfully.';
    header('Location: /foodfusion/admin/culinaryTrends');
}

    public function CulinaryTrends(){
        $Trend = new Trend();
        $trends = $Trend->getAll();
        include_once __DIR__.'/../views/pages/culinaryTrends.php';
    }

    public function postCulinaryTrends()
    {
        include_once __DIR__.'/../views/pages/postCulinaryTrends.php';
    }

    public function postCulinaryTrendsProcess()
    {
        $trend = new Trend();
        // Collect input
        $data = [
            'trend_title' => trim($_POST['trend_title'] ?? ''),
            'trend_description' => trim($_POST['trend_description'] ?? ''),
            'trend_image' => $_FILES['trend_image'] ?? null
        ];

        $errors = [];
        // Basic validation
        foreach ($data as $key => $value) {
            if (empty($value) && $key !== 'trend_image') {
                $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
            }
        }

        if (!empty($data['trend_image']['name'])) {
            $uploadResult = $trend->uploadCulinaryTrendImage('trend_image');
            if (isset($uploadResult['error'])) {
                $errors['trend_image'] = $uploadResult['error'];
            } else {
                $data['trend_image'] = $uploadResult['path'];
            }
        } else {
            $data['trend_image'] = '/uploads/trends/default.png'; // fallback only if no upload
        }

        // If errors exist
        if (!empty($errors)) {
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $data;
            header('Location: /foodfusion/admin/postCulinaryTrends');
            exit;
        }

        // Process the data
        if ($trend->createCulinaryTrend($data)) {
            $_SESSION['success'] = "Culinary trend posted successfully!";
            header('Location: /foodfusion/admin/culinaryTrends');
            exit;
        } else {
            $_SESSION['error'] = ['general' => 'Failed to post culinary trend. Please try again.'];
            header('Location: /foodfusion/admin/postCulinaryTrends');
            exit;
        }
    }
}


?>
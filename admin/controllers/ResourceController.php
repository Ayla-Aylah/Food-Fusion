<?php
namespace AdminController;

use Model\Resource;
use AdminModel\AdminResource;
class ResourceController{
    public function postRecipeCardForm(){
        include_once __DIR__.'/../views/pages/postRecipeCard.php';
    }
    public function recipeCardList(){
        include_once __DIR__.'/../views/pages/recipeCardList.php';
    }
    public function infoList(){
          $model = new AdminResource();
        $infos = $model->getAllInfo();
        include_once __DIR__.'/../views/pages/infoList.php';
    }
    public function editRecipeCardForm(){
        include_once __DIR__.'/../views/pages/editRecipeCard.php';
    }
    public function editinfoform($id){
         $model = new AdminResource();
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /foodfusion/admin/infoList");
        exit;
    }

    $info = $model->getInfoById($id);

    if (!$info) {
        $_SESSION['error'] = "Tutorial not found.";
        header("Location: /foodfusion/admin/infoList");
        exit;
    }
        include_once __DIR__.'/../views/pages/editInfo.php';
    }
    public function deleteInfo(){
        $model = new AdminResource();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /foodfusion/admin/infoList");
            exit;
        }

        $model->deleteInfoById($id);
        header("Location: /foodfusion/admin/infoList");
        exit;
    }
    public function postInfo(){
      
        include_once __DIR__.'/../views/pages/postInfo.php';
    }

    public function postInfoProcess(){
        
    $errors = [];
    $old = $_POST;

    // Collect form data
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $model = new AdminResource();

    // Basic validation
    if (empty($title)) $errors['title'] = 'Title is required.';
    if (empty($description)) $errors['description'] = 'Description is required.';
  
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        $errors['file'] = 'File is required.';
    } else {
        $filePath = $this->uploadInfoImage('file');
        if (!$filePath) {
            $errors['file'] = 'Upload failed.';
        }
    }


    // If no errors, insert into database
    if (empty($errors)) {

        $data = [
            'title' => $title,
            'description' => $description,
            'image' => $filePath['path'] ?? null
            ];
           
        $model->addinfo($data);

        header("Location: /foodfusion/admin/infoList");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: /foodfusion/admin/infoList");
        exit;
    }
}


public function uploadInfoImage($fileInputName, $subFolder = 'infographics/', $allowedTypes = ['jpg', 'jpeg', 'png'], $maxSize = 2 * 1024 * 1024)
    {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'No file uploaded or upload error.'];
    }
    $file = $_FILES[$fileInputName];
    $fileName = basename($file['name']);
    $fileSize = $file['size'];
    $fileTmpPath = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        return ['error' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedTypes)];
    }
    // Validate file size
    if ($fileSize > $maxSize) {
        return ['error' => 'File size exceeds the maximum limit of ' . ($maxSize / 1024 / 1024) . ' MB.'];
    }
    // Create subfolder if it doesn't exist
    $uploadDir = __DIR__ . '/../../public/uploads/' . $subFolder;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    // Generate a unique file name to avoid overwriting
    $uniqueFileName = uniqid('', true) . '.' . $fileType;
    $destinationPath = $uploadDir . $uniqueFileName;
    // Move the uploaded file to the destination path
    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        return ['path' => '/uploads/' . $subFolder . $uniqueFileName];
    } else {
        return ['error' => 'Failed to move uploaded file.'];
    }}
    
    public function cookingTutorials(){
    $res = new AdminResource();
    $tutorials = $res->getAllTutorials();
        include_once __DIR__.'/../views/pages/tutorialList.php';
    }
    public function postCookingTutorial(){
        include_once __DIR__.'/../views/pages/postCookingTutorial.php';
    }
    public function hacks(){
        $model = new AdminResource();
        $hacks = $model->gethacks();
        include_once __DIR__.'/../views/pages/hacks.php';
    }
    public function postHacks(){
        include_once __DIR__.'/../views/pages/postHacks.php';
    }

    public function postEduResources(){
        include_once __DIR__.'/../views/pages/postEduResources.php';
    }
    public function eduResources(){
        $resModal = new AdminResource();
        $resources = $resModal->getAllResources('educational_resources');
        include_once __DIR__.'/../views/pages/eduResources.php';
    }
    // Show Edit Form
public function editTutorialForm() {
    $model = new AdminResource();
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /foodfusion/admin/cookingTutorials");
        exit;
    }

    $tutorial = $model->getTutorialById($id);

    if (!$tutorial) {
        $_SESSION['error'] = "Tutorial not found.";
        header("Location: /foodfusion/admin/cookingTutorials");
        exit;
    }

    include_once __DIR__ . '/../views/pages/editTutorial.php';
}
public function updateTutorialProcess() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /foodfusion/admin/tutorialList");
        exit;
    }

    $errors = [];

    $id = $_POST['id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $cuisine = trim($_POST['cuisine'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $difficulty = trim($_POST['difficulty'] ?? '');
    $cooking_time = trim($_POST['cooking_time'] ?? '');

    $model = new AdminResource();
    $existing = $model->getTutorialById($id);

    // Validation
    if (empty($title)) $errors['title'] = 'Title is required.';
    if (empty($description)) $errors['description'] = 'Description is required.';

    $videoPath = $existing['video_link'];

    // Handle video file upload
    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === 0) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/tutorial_videos/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('', true) . '.' . $extension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $targetPath)) {
            $videoPath = "uploads/tutorial_videos/$fileName";
        } else {
            $errors['video_file'] = 'Video upload failed.';
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header("Location: /foodfusion/admin/editTutorial?id=$id");
        exit;
    }

    // Prepare data to update
    $data = [
        'title' => $title,
        'description' => $description,
        'video_link' => $videoPath,
        'cuisine' => $cuisine,
        'diet' => $diet,
        'difficulty' => $difficulty,
        'cooking_time' => $cooking_time
    ];

    // Update database
    $model->updateTutorialById($id, $data);

    // Redirect back to list
    header("Location: /foodfusion/admin/tutorialList");
    exit;
}

// Delete tutorial
public function deleteTutorial() {
    $model = new AdminResource();
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /foodfusion/admin/cookingTutorials");
        exit;
    }

    $model->deleteTutorialById($id);
    header("Location: /foodfusion/admin/cookingTutorials");
    exit;
}

public function postCookingTutorialProcess() {
    $errors = [];
    $old = $_POST;

    // Collect form data
    $data = [
        'title'        => trim($_POST['title'] ?? ''),
        'description'  => trim($_POST['description'] ?? ''),
        'cuisine'      => trim($_POST['cuisine'] ?? ''),
        'diet'         => trim($_POST['diet'] ?? ''),
        'difficulty'   => trim($_POST['difficulty'] ?? ''),
        'cooking_time'   => trim($_POST['cooking_time'] ?? '')
    ];

    $model = new AdminResource();

    // Validate required fields
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        }
    }

    // Validate file uploads
    if (!isset($_FILES['video_file']) || $_FILES['video_file']['error'] !== 0) {
        $errors['video_file'] = 'Video file is required.';
    }

    // Upload video
    if (empty($errors)) {
        $videoPath = $this->uploadFile('video_file');
        $data['video_file'] = $videoPath;

        $model->addCookingTutorial($data); 
        header("Location: /foodfusion/admin/cookingTutorials");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $data;
        header("Location: /foodfusion/admin/postCookingTutorial");
        exit;
    }
}



public function postRecipeCardProcess() {
    $errors = [];
    $old = $_POST;

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $cuisine = trim($_POST['cuisine'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $difficulty = trim($_POST['difficulty'] ?? '');
    $cooking_time = trim($_POST['cooking_time'] ?? '');

    $model = new AdminResource();

    // Validate required fields
    if (empty($title)) {
        $errors['title'] = 'Title is required.';
    }
    if (empty($description)) {
        $errors['description'] = 'Description is required.';
    }
    if (empty($cuisine)) {
        $errors['cuisine'] = 'Cuisine type is required.';
    }
    if (empty($diet)) {
        $errors['diet'] = 'Dietary preference is required.';
    }
    if (empty($difficulty)) {
        $errors['difficulty'] = 'Difficulty level is required.';
    }
    if (empty($cooking_time)) {
        $errors['cooking_time'] = 'cooking time is required.';
    }

    // Validate file upload for recipe card file (PDF/Image)
    if (!isset($_FILES['file_path']) || $_FILES['file_path']['error'] !== 0) {
        $errors['file_path'] = 'Recipe card file is required.';
    }

    // Validate cover photo upload
    if (!isset($_FILES['cover_photo']) || $_FILES['cover_photo']['error'] !== 0) {
        $errors['cover_photo'] = 'Cover photo is required.';
    }

    // Upload cover photo if no error yet
    if (empty($errors['cover_photo'])) {
        $uploadResult = $model->uploadCoverPhoto('cover_photo');
        if (isset($uploadResult['error'])) {
            $errors['cover_photo'] = $uploadResult['error'];
        } else {
            $coverPhotoPath = $uploadResult['path'];
        }
    }

    if (empty($errors)) {
        // Upload recipe card file
        $filePath = $this->uploadFile('file_path');

        $data = [
            'title' => $title,
            'description' => $description,
            'file_path' => $filePath,
            'cover_photo' => $coverPhotoPath,
            'cuisine' => $cuisine,
            'diet' => $diet,
            'difficulty' => $difficulty,
            'cooking_time' => $cooking_time
        ];

        $model->addRecipeCard($data);
        header("Location: /foodfusion/admin/recipeCardList");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: /foodfusion/admin/postRecipeCard");
        exit;
    }}

public function postHacksProcess() {
    $errors = [];
    $old = $_POST;

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $model = new AdminResource();

    // Validate required fields
    if (empty($title)) {
        $errors['title'] = 'Title is required.';
    }
    if (empty($description)) {
        $errors['description'] = 'Description is required.';
    }
   

    // Validate file upload for recipe card file (PDF/Image)
    if (!isset($_FILES['video_file']) || $_FILES['video_file']['error'] !== 0) {
        $errors['video_file'] = 'Video file is required.';
    }
 
    if (empty($errors)) {
        $videoPath = $this->uploadFile('video_file');

        $data = [
            'title' => $title,
            'description' => $description,
            'video_file' => $videoPath
        ];

        $model->addHacks($data);
        header("Location: /foodfusion/admin/hacks");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: /foodfusion/admin/postHacks");
        exit;
    }

}
  public function uploadFile($fieldName) {
    $uploadDir = __DIR__ . '/../../public/uploads/videos/'; 

    // Make sure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // recursively create folder
    }

    $fileName = uniqid() . '_' . basename($_FILES[$fieldName]['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
        // Save a path relative to web root for storing in DB
        return 'uploads/videos/' . $fileName;
    } else {
        return null;
    }
    }


public function uploadCoverPhoto($fieldName) {
    $uploadDir = 'public/uploads/images/';
    $fileName = uniqid() . '_' . basename($_FILES[$fieldName]['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
        return ['path' => $targetPath];
    }

    return ['error' => 'Failed to upload cover photo.'];
}
public function postEduResourcesProcess() {
    $errors = [];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $type = $_POST['type'] ?? '';
    $filePath = null;
    $videoPath = null;
    $coverPhotoPath = null;
    $model = new AdminResource();

    // Basic validation
    if (empty($title)) $errors['title'] = 'Title is required.';
    if (empty($description)) $errors['description'] = 'Description is required.';
    if (empty($type)) $errors['type'] = 'Type is required.';

    if ($type === 'download' || $type === 'infographic') {
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        $errors['file'] = 'File is required.';
    } else {
        $filePath = $model->uploadEducationalFile('file', $type);

        if (!$filePath) {
            $errors['file'] = 'Upload failed.';
        } elseif ($type === 'download') {
            // Only attempt cover upload if file was successfully uploaded
            $uploadResult = $model->uploadCoverPhoto('cover_image');
            if (isset($uploadResult['error'])) {
                $errors['cover_image'] = $uploadResult['error'];
            } else {
                $coverPhotoPath = $uploadResult['path'];
            }
        }
    }
}

    if ($type === 'video') {
        if (!isset($_FILES['video_file']) || $_FILES['video_file']['error'] !== 0) {
            $errors['video_file'] = 'Video is required.';
        } else {
            $videoPath = $this->uploadFile('video_file');
            if (empty($videoPath)) {
                $errors['video_file'] = 'Video upload failed.';
            }
        }
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $finalPath = null;
        if ($type === 'video') {
            $finalPath = $videoPath;
        } elseif ($type === 'download' || $type === 'infographic') {
            $finalPath = $filePath;
        }

        $data = [
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'file_path' => $finalPath,
            'cover_image' => $coverPhotoPath
            ];
           
        $model->addEducationalResource($data);

        header("Location: /foodfusion/admin/EduResources");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: /foodfusion/admin/postEduResources");
        exit;
    }
}
        public function editForm(){
        $res = new AdminResource();
        $id = $_GET['id'];
        $resource = $res->getresbyid($id);
        include_once __DIR__ . '/../views/pages/editEdu.php';
    }
        public function editHackForm(){
        $res = new AdminResource();
        $id = $_GET['id'];
        $hack = $res->gethackbyid($id);
        include_once __DIR__ . '/../views/pages/editHack.php';
    }

public function updateResource($id) {
    $errors = [];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $type = $_POST['type'] ?? '';
    $filePath = null;
    $videoPath = null;
    $coverPhotoPath = null;

    $model = new AdminResource();

    // Basic validation
    if (empty($title)) $errors['title'] = 'Title is required.';
    if (empty($description)) $errors['description'] = 'Description is required.';
    if (empty($type)) $errors['type'] = 'Type is required.';


    $existing = $model->getresbyid($id);
  // File upload handling based on type
    if ($type === 'download' || $type === 'infographic') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === 0){
            $filePath = $model->uploadEducationalFile('file', $type);
           
            if (!$filePath) $errors['file'] = 'File upload failed.';
        }

        if ($type === 'download' && isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
            $coverUpload = $model->uploadCoverPhoto('cover_image');
            if (isset($coverUpload['error'])) $errors['cover_image'] = $coverUpload['error'];
            else $coverPhotoPath = $coverUpload['path'];
        }
    }           
    if ($type === 'video') {
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === 0) {
            $videoPath = $this->uploadFile('video_file');
            if (empty($videoPath)) $errors['video_file'] = 'Video upload failed.';
        }
    }

    // If no errors, proceed to update
    if (empty($errors)) {
        $finalPath = $existing['file_path'];
        if ($type === 'video') {
            if ($videoPath) $finalPath = $videoPath;
            else $finalPath = $existing['file_path'];
        } elseif ($type === 'download' || $type === 'infographic') {
            if ($filePath) $finalPath = $filePath;
            else {
                if ($type !== $existing['type']) {
                    $finalPath = '';
                }
            }
        }
        $data = [
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'file_path' => $finalPath,
            'cover_image' => $coverPhotoPath ?? $existing['cover_image']
        ];

        $model->updateResourceById($id, $data);

        header("Location: /foodfusion/admin/EduResources");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        header("Location: /foodfusion/editEduResource?id=$id");
        exit;
    }
}
public function updateHack($id)
{
    $errors = [];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $filePath = null;

    $model = new AdminResource();

    if (empty($title)) $errors['title'] = 'Title is required.';
    if (empty($description)) $errors['description'] = 'Description is required.';

    // If a new file uploaded
    if (isset($_FILES['video_link']) && $_FILES['video_link']['error'] === 0) {
        $filePath = $model->uploadHackFile('video_link');
        if (!$filePath) $errors['video_link'] = 'video_link upload failed.';
    }

    if (empty($errors)) {
        // Get existing data to retain old file if no new file uploaded
        $existing = $model->getHackById($id);
        $finalPath = $filePath ?: $existing['video_link'];

        $data = [
            'title'       => $title,
            'description' => $description,
            'video_link'   => $finalPath
        ];
 
        $model->updateHackById($id, $data);

        header("Location: /foodfusion/admin/hacks");
        exit;
    } else {
        $_SESSION['error'] = $errors;
        header("Location: /foodfusion/editHack?id=$id");
        exit;
    }
}


    public function deleteHack(){
        $id = $_GET['id'];
        $res = new AdminResource();
        $res->deletehackById($id);
        $_SESSION['success'] = 'hack deleted successfully.';
        header('Location: /foodfusion/admin/hacks');
        exit;
    }

   public function deleteEdu(){
        $id = $_GET['id'];
        $res = new AdminResource();
        $res->deleteById($id);
        $_SESSION['success'] = 'resource deleted successfully.';
        header('Location: /foodfusion/admin/eduResources');
        exit;
    }

    public function updateRecipeCardProcess() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /foodfusion/admin/recipeCardList");
        exit;
    }

    $id = $_POST['id'];
    $model = new AdminResource();
    $existing = $model->getRecipeCardById($id);

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $cuisine = trim($_POST['cuisine'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $difficulty = trim($_POST['difficulty'] ?? '');
    $cooking_time = trim($_POST['cooking_time'] ?? '');

    $filePath = $existing['file_path'];
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $filePath = $this->uploadFile('file', 'resources');
    }

    $coverPhoto = $existing['cover_photo'];
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] === 0) {
        $coverPhoto = $this->uploadFile('cover_photo', 'images');
    }

    $data = [
        'title' => $title,
        'description' => $description,
        'file_path' => $filePath,
        'cover_photo' => $coverPhoto,
        'cuisine' => $cuisine,
        'diet' => $diet,
        'difficulty' => $difficulty,
        'cooking_time' => $cooking_time
    ];

    $model->updateRecipeCardById($id, $data);

    header("Location: /foodfusion/admin/recipeCardList");
    exit;
}

    public function updateInfoProcess($id) {
    $id = $_GET['id'];
    $model = new AdminResource();
    $existing = $model->getInfoById($id);

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    $filePath = $existing['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $filePath = $this->uploadFile('image');
    }
    $data = [
        'title' => $title,
        'description' => $description,
        'image' => $filePath
    ];
    $model->updateinfobyid($id, $data);

    header("Location: /foodfusion/admin/infoList");
    exit;
}

public function deleteRecipeCard() {
    $id = $_GET['id'];
    $model = new AdminResource();
    $model->deleteRecipeCard($id);
    header("Location: /foodfusion/admin/recipeCardList");
    exit;
}


}
?>
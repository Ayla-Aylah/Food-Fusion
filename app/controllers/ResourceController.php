<?php
namespace Controller;

use Model\Resource;
use Model\User;

class ResourceController {
    private function getUserData() {
    $userModel = new User();

    if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        $userId = $_SESSION['user']['id'];
        $user = $userModel->findById($userId);
    } else {
        $user = null;
    }

        return [
            'user' => $user,
            'user_profile' => $user['profile_image'] ?? null
        ];
    }

    private function render($viewPath) {
        extract($this->getUserData());
        include_once(__DIR__ . "/../views/pages/{$viewPath}.php");
    }

    public function culinaryResources() {
        $resourceModel = new Resource();
        $recipeCards = $resourceModel->getRecipeCards();
        $tutorials = $resourceModel->getTutorialVideos();
        $hacks = $resourceModel->getKitchenHacks();
        $infographics = $resourceModel->getculInfographics();
        include_once(__DIR__ . "/../views/pages/culResources.php");
    }
    public function educationalResources() {
    $resourceModel = new Resource();

    // Using separate methods
    $downloads = $resourceModel->getDownloads();
    $infographics = $resourceModel->getInfographics();
    $videos = $resourceModel->getVideos();


    include __DIR__ . '/../views/pages/eduResources.php';
}

public function downloadResource($type, $fileName) {
    // Decode the URL-encoded filename
    $fileName = urldecode($fileName);

    // Build the full file path
    $filePath = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/$type/$fileName";

    // Check if file exists
    if (!file_exists($filePath)) {
        header("HTTP/1.0 404 Not Found");
        echo "File not found.";
        exit;
    }

    // Set headers for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));

    // Clean output buffer and read the file
    ob_clean();
    flush();
    readfile($filePath);
    exit;
}

}
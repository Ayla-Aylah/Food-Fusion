<?php
namespace Controller;

use AdminModel\Admin;
use AdminModel\Recipe;
use Model\User;
use Model\Recipe as UserRecipe;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class RecipeController {
    
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
        
    public function recipeCollection() {
        $recipeModel = new Recipe();
        $adminRecipes = $recipeModel->getAllRecipes();

        // Sanitize and get search/filter inputs
        $searchTitle = isset($_GET['title']) ? trim($_GET['title']) : '';
        $searchCuisine = isset($_GET['cuisine']) ? trim($_GET['cuisine']) : '';
        $searchDiet = isset($_GET['diet']) ? trim($_GET['diet']) : '';
        $searchDifficulty = isset($_GET['difficulty']) ? trim($_GET['difficulty']) : '';

        $filteredRecipes = array_filter($adminRecipes, function ($recipe) use ($searchTitle, $searchCuisine, $searchDiet, $searchDifficulty) {
            // Title: partial, case-insensitive match
            if ($searchTitle !== '' && stripos($recipe['title'], $searchTitle) === false) {
                return false;
            }
            // Cuisine exact match if provided
            if ($searchCuisine !== '' && $recipe['cuisine_type'] !== $searchCuisine) {
                return false;
            }
            // Diet exact match if provided
            if ($searchDiet !== '' && $recipe['dietary_preference'] !== $searchDiet) {
                return false;
            }
            // Difficulty exact match if provided
            if ($searchDifficulty !== '' && $recipe['difficulty'] !== $searchDifficulty) {
                return false;
            }
            return true;
        });

        $searchParams = [
            'title' => $searchTitle,
            'cuisine' => $searchCuisine,
            'diet' => $searchDiet,
            'difficulty' => $searchDifficulty,
        ];
        
            extract($this->getUserData());
            include_once __DIR__ . '/../views/pages/recipeCollection.php';
    }
    
    public function recipeDetails() {
    $isLoggedIn = isset($_SESSION['user']); 
    $recipeModel = new Recipe();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $recipe = $recipeModel->getRecipeById($id);
    $ingredients = $recipeModel->getIngredientsByRecipeId($id);
    $instructions = $recipeModel->getInstructionsByRecipeId($id);
    $likeCount = 0;
    $hasLiked = false;
    $favCount = 0;
    $hasfav = false;
    
    $comments = $recipeModel->getCommentsByRecipeId($id);
    $userModel = new User();

    if (!$recipe) {
        header('HTTP/1.0 404 Not Found');
        echo 'Recipe not found';
        exit;
    }

    $likeCount = $recipeModel->countLikes($id);
    $favCount = $recipeModel->countFav($id);
   
    if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        $userId = $_SESSION['user']['id'];
        $user = $userModel->findById($userId);
        $hasLiked = $recipeModel->hasLiked($userId, $id);
        $hasfav = $recipeModel->hasFav($userId, $id);
    }
        include_once __DIR__ . '/../views/pages/recipeDetails.php';
    }

    public function toggleLike() {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Login required']);
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? 0;

    $likeModel = new Recipe(); 
    $liked = $likeModel->hasLiked($userId, $recipeId);

    if ($liked) {
        $likeModel->removeLike($userId, $recipeId);
    } else { 
        $likeModel->addLike($userId, $recipeId);
    }

    $count = $likeModel->countLikes($recipeId);

    echo json_encode([
        'success' => true,
        'liked' => !$liked,
        'like_count' => $count
    ]);
}
    public function toggleFav() {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Login required']);
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? 0;

    $recipeModel = new Recipe(); 
    $faved = $recipeModel->hasFav($userId, $recipeId);

    if ($faved) {
        $recipeModel->removeFav($userId, $recipeId);
    } else { 
        $recipeModel->addFav($userId, $recipeId);
    }
    $count = $recipeModel->countFav($recipeId);

    echo json_encode([
        'success' => true,
        'faved' => !$faved,
        'fav_count' => $count
    ]);
}
public function submitComment()
{
    $cookbookmodel = new Recipe();

    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = 'Login required to comment.';
        header("Location: /foodfusion/public/login");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? null;
    $comment = trim($_POST['comment'] ?? '');

    if (!$recipeId) {
        $_SESSION['error'] = 'Invalid recipe ID.';
        header("Location: /foodfusion/public/recipeDetails?id=".$recipeId);
        exit;
    }

    if (empty($comment)) {
        $_SESSION['error'] = 'Comment must not be empty.';
        header("Location: /foodfusion/public/recipeDetails?id=" . $recipeId);
        exit;
    }

    $cookbookmodel->addComment($recipeId, $userId, $comment);
    $_SESSION['success'] = 'Comment posted successfully!';
    header("Location: /foodfusion/public/recipeDetails?id=" . $recipeId);
    exit;
}

public function filedownload()
{
// Get filename from query param, sanitize it carefully!
$file = $_GET['file'] ?? '';

$baseDir = __DIR__ . '/uploads/resources/'; // your resource folder

// Prevent directory traversal attacks:
$file = basename($file);

$fullPath = $baseDir . $file;

if (!file_exists($fullPath)) {
    http_response_code(404);
    exit('File not found');
}

// Set headers to force download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($fullPath));
flush();
readfile($fullPath);
exit;

}
}
?>
<?php
namespace Controller;

use Model\User;
use Model\CookBook;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CookBookController {

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
    
    public function communityCookBook(){
        
        $cookModel = new CookBook();
        $recipes = $cookModel->getAllRecipes();
        $tips = $cookModel->getAllTips();
        $experiences = $cookModel->getAllExperiences();
        
        $searchTitle = isset($_GET['title']) ? trim($_GET['title']) : '';
        $searchCuisine = isset($_GET['cuisine']) ? trim($_GET['cuisine']) : '';
        $searchDiet = isset($_GET['diet']) ? trim($_GET['diet']) : '';
        $searchDifficulty = isset($_GET['difficulty']) ? trim($_GET['difficulty']) : '';

        $filteredRecipes = array_filter($recipes, function ($recipe) use ($searchTitle, $searchCuisine, $searchDiet, $searchDifficulty) {
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
            'difficulty' => $searchDifficulty
        ];
            extract($this->getUserData());
            include_once __DIR__ . '/../views/pages/communityCookBook.php';
    }
    
    public function shareRecipe(){
        extract($this->getUserData());
        include_once(__DIR__ . "/../views/pages/shareRecipe.php");
    }
    public function shareRecipeProcess(){
        
    $cookbook = new CookBook();
    $user_id = $_SESSION['user']['id'];
    $postedby = $_SESSION['user']['username'];
    // Collect form data
    $data = [
        'user_id' => $user_id,
        'recipe_title'        => trim($_POST['recipe_title'] ?? ''),
        'recipe_description'  => trim($_POST['recipe_description'] ?? ''),
        'recipe_tips'         => trim($_POST['recipe_tips'] ?? ''),
        'nutrition'           => trim($_POST['nutrition'] ?? ''),
        'cuisine'             => trim($_POST['cuisine'] ?? ''),
        'diet'                => trim($_POST['diet'] ?? ''),
        'difficulty'          => trim($_POST['difficulty'] ?? ''),
        'cooking_time'        => trim($_POST['cooking_time'] ?? ''),
        'postedby' => $postedby
    ];
   

    // Validate required fields
    $errors = [];
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        }
    }

    // Validate ingredients
    if (empty($_POST['ingredient_name']) || !is_array($_POST['ingredient_name'])) {
        $errors['ingredients'] = 'Please add at least one ingredient.';
    } else {
        foreach ($_POST['ingredient_name'] as $ingredient) {
            if (empty(trim($ingredient))) {
                $errors['ingredients'] = 'Ingredient name cannot be empty.';
                break;
            }
        }
    }

    // Validate instructions
    if (empty($_POST['step_number']) || !is_array($_POST['step_number'])) {
        $errors['instructions'] = 'Please add at least one instruction.';
    } else {
        foreach ($_POST['step_text'] as $step) {
            if (empty(trim($step))) {
                $errors['instructions'] = 'Instruction step cannot be empty.';
                break;
            }
        }
    }

    // If validation errors found, redirect back
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareRecipe');
        exit;
    }

    // Upload recipe image
    $uploadResult = $cookbook->uploadRecipePhoto('recipe_photo');
    if (isset($uploadResult['error'])) {
        $_SESSION['error'] = ['recipe_photo' => $uploadResult['error']];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareRecipe');
        exit;
    }

    // Add image path to recipe data
    $data['recipe_photo'] = $uploadResult['path'];

    // Insert main recipe and capture its ID
    $recipeId = $cookbook->insertSharedRecipe($data);
    if (!$recipeId) {
        $_SESSION['error'] = ['recipe' => 'Failed to insert recipe.'];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareRecipe');
        exit;
    }

    // Insert ingredients
    foreach ($_POST['ingredient_name'] as $index => $name) {
        if (!empty(trim($name))) {
            $quantity = $_POST['quantity'][$index] ?? '';
            $unit     = $_POST['unit'][$index] ?? '';
            $cookbook->addRecipeIngredient($recipeId, $name, $quantity, $unit);
        }
    }

    // Insert instructions
    foreach ($_POST['step_number'] as $index => $stepNum) {
        $stepText = $_POST['step_text'][$index] ?? '';
        if (!empty(trim($stepText))) {
            $cookbook->addRecipeInstruction($recipeId, $stepNum, $stepText);
        }
    }

    // Success message & redirect
    $_SESSION['success'] = 'Recipe posted successfully!';
    header('Location: /foodfusion/public/communityCookBook');
    exit;
    }
    
    public function shareTipProcess(){
    $cookbook = new CookBook();
    $user_id = $_SESSION['user']['id'];
    $postedby = $_SESSION['user']['username'];
    
    $data = [
        'user_id' => $user_id,
        'tip_title'=> trim($_POST['tip_title'] ?? ''),
        'tip_description'=> trim($_POST['tip_description'] ?? ''),
        'postedby' => $postedby
    ];
    
    $errors = [];
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        }
    }

      if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareTip');
        exit;
    }
    $uploadResult = $cookbook->uploadTipPhoto('tip_photo');
    if (isset($uploadResult['error'])) {
        $_SESSION['error'] = ['tip_photo' => $uploadResult['error']];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareTip');
        exit;
    }

    $data['tip_photo'] = $uploadResult['path'];
    $recipeId = $cookbook->insertSharedTip($data);
    if (!$recipeId) {
        $_SESSION['error'] = ['tip' => 'Failed to insert recipe.'];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareTip');
        exit;
    }
    
    $_SESSION['success'] = 'Tip posted successfully!';
    header('Location: /foodfusion/public/communityCookBook');
    exit;
    }
    
    public function shareExperienceProcess(){
    $cookbook = new CookBook();
    $user_id = $_SESSION['user']['id'];
    $postedby = $_SESSION['user']['username'];
    
    $data = [
        'user_id' => $user_id,
        'title'=> trim($_POST['title'] ?? ''),
        'description'=> trim($_POST['description'] ?? ''),
        'postedby' => $postedby
    ];
    
    $errors = [];
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        }
    }

      if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareExperience');
        exit;
    }
    
    $uploadResult = $cookbook->uploadExperiencePhoto('image_path');
    if (isset($uploadResult['error'])) {
        $_SESSION['error'] = ['image_path' => $uploadResult['error']];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareExperience');
        exit;
    }

    $data['image_path'] = $uploadResult['path'];
    $recipeId = $cookbook->insertSharedExperience($data);
    if (!$recipeId) {
        $_SESSION['error'] = ['tip' => 'Failed to insert recipe.'];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/public/shareExperience');
        exit;
    }

    $_SESSION['success'] = 'Experience posted successfully!';
    header('Location: /foodfusion/public/communityCookBook');
    exit;
    }
    
public function cookbookDetails() {
    $isLoggedIn = isset($_SESSION['user']); 
    $recipeModel = new CookBook();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $recipe = $recipeModel->getRecipeById($id);
    $ingredients = $recipeModel->getIngredientsByRecipeId($id);
    $instructions = $recipeModel->getInstructionsByRecipeId($id);
    $likeCount = 0;
    $hasLiked = false;
    $favCount = 0;
    $hasfav = false;
    $userModel = new User();
    $comments = $recipeModel->getCommentsByRecipeId($id);
    
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
        include_once __DIR__ . '/../views/pages/cookbookDetails.php';
    }

    public function toggleLike() {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Login required']);
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? 0;

    $likeModel = new CookBook(); 
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

    public function shareTip(){
        extract($this->getUserData());
        include_once(__DIR__ . "/../views/pages/shareTip.php");
    }
    
    public function shareExperience(){
        extract($this->getUserData());
        include_once(__DIR__ . "/../views/pages/shareExperience.php");
    }
    
    public function toggleFav() {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Login required']);
        exit;
    }
    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? 0;
    $recipeModel = new CookBook(); 
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
    $cookbookmodel = new CookBook();

    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = 'Login required to comment.';
        header("Location: /foodfusion/public/login");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $recipeId = $_POST['recipe_id'] ?? null;
    $comment = trim($_POST['comment'] ?? '');

    $errors = [];
    if (!$recipeId) {
        $errors['comment'] = 'Invalid recipe ID.';
        header("Location: /foodfusion/public/communityCookBook");
        exit;
    }

    if (empty($comment)) {
        $$errors['comment'] = 'Comment must not be empty.';
        header("Location: /foodfusion/public/communityCookBook/cookbookDetails?id=" . $recipeId);
        exit;
    }
    $_SESSION['error'] = $errors;
    
    $cookbookmodel->addComment($recipeId, $userId, $comment);
    $_SESSION['success'] = 'Comment posted successfully!';
    header("Location: /foodfusion/public/communityCookBook/cookbookDetails?id=" . $recipeId);
    exit;
}
}
?>
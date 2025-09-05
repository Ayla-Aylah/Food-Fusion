<?php
// Set time zone and session
date_default_timezone_set('Asia/Yangon');
if (session_status() === PHP_SESSION_NONE) session_start();

// Autoload dependencies
require_once '../vendor/autoload.php';

// Import controllers
use AdminController\RecipeController;
use Controller\AuthController;
use Controller\PageController;
use Controller\ProfileController;
use Controller\RecipeController as RecipeCollectionController;
use Controller\CookBookController;
use Controller\ContactController;
use Controller\ResourceController;

// Normalize URI
$basePath = '/foodfusion/public';
$uri = rtrim(str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/') ?: '/';
$segments = explode('/', trim($uri, '/'));
$method = $_SERVER['REQUEST_METHOD'];

// Instantiate controllers
$AuthController = new AuthController();
$PageController = new PageController();
$ProfileController = new ProfileController();
$RecipeController = new RecipeCollectionController();
$CookBookController = new CookBookController();
$ContactController = new ContactController();
$ResourceController = new ResourceController();

// Routing
switch (true) {

    // Auth
    case $uri === '/register' && $method === 'GET':
        $AuthController->registerForm();
        break;
    case $uri === '/register' && $method === 'POST':
        $AuthController->registerProcess();
        break;
    case $uri === '/login' && $method === 'GET':
        $AuthController->loginForm();
        break;
    case $uri === '/login' && $method === 'POST':
        $AuthController->loginProcess();
        break;
    case $uri === '/logout' && $method === 'GET':
        $ProfileController->logout();
        break;

    // Static Pages
    case $uri === '/' && $method === 'GET':
        $PageController->home();
        break;
    case $uri === '/terms' && $method === 'GET':
        $PageController->terms();
        break;
    case $uri === '/privacy' && $method === 'GET':
        $PageController->privacy();
        break;
    case $uri === '/aboutUs' && $method === 'GET':
        $PageController->aboutUs();
        break;
    case $uri === '/cookiePolicy' && $method === 'GET':
        $PageController->cookiePolicy();
        break;

    // Profile
    case $uri === '/profile' && $method === 'GET':
        $ProfileController->viewProfile();
        break;
    case $uri === '/profile' && $method === 'POST':
        $ProfileController->updateProfile();
        break;
    case $uri === '/deleteAccount' && $method === 'POST':
        $ProfileController->delete();
        break;

    // Contact
    case $uri === '/contactUs' && $method === 'GET':
        $ContactController->contactUs();
        break;
    case $uri === '/contactUs' && $method === 'POST':
        $ContactController->contactUsProcess();
        break;

    // Recipes
    case $uri === '/recipeCollection' && $method === 'GET':
        $RecipeController->recipeCollection();
        break;

    case $uri === '/recipeDetails' && $method === 'GET':
        $RecipeController->recipeDetails();
        break;

        
    case $uri === '/recipelikeToggle' && $method === 'POST':
        $RecipeController->toggleLike();
        break;


    case $uri === '/recipefavToggle' && $method === 'POST':
        $CookBookController->toggleFav();
        break;

        
    case $uri === '/submitComment' && $method === 'POST':
        $RecipeController->submitComment();
        break;

    // Community Cookbook
    case $uri === '/communityCookBook' && $method === 'GET':
        $CookBookController->communityCookBook();
        break;
    case $uri === '/communityCookBook/cookbookDetails' && $method === 'GET':
        $CookBookController->cookbookDetails();
        break;
    case $uri === '/shareRecipe' && $method === 'GET':
        $CookBookController->shareRecipe();
        break;
    case $uri === '/shareRecipe' && $method === 'POST':
        $CookBookController->shareRecipeProcess();
        break;
    case $uri === '/shareExperience' && $method === 'GET':
        $CookBookController->shareExperience();
        break;
    case $uri === '/shareExperience' && $method === 'POST':
        $CookBookController->shareExperienceProcess();
        break;
    case $uri === '/shareTip' && $method === 'GET':
        $CookBookController->shareTip();
        break;
    case $uri === '/shareTip' && $method === 'POST':
        $CookBookController->shareTipProcess();
        break;
    case $uri === '/likeToggle' && $method === 'POST':
        $CookBookController->toggleLike();
        break;
    case $uri === '/favToggle' && $method === 'POST':
        $RecipeController->toggleFav();
        break;
    case $uri === '/submitCommentUser' && $method === 'POST':
        $CookBookController->submitComment();
        break;

    // Resources
    case $uri === '/culinaryResources' && $method === 'GET':
        $ResourceController->culinaryResources();
        break;
    case $uri === '/educationalResources' && $method === 'GET':
        $ResourceController->educationalResources();
        break;
    case $segments[0] === 'download' && isset($segments[1]) && isset($_GET['type']):
        $ResourceController->downloadResource($_GET['type'], $segments[1]);
        break;

    // 404 fallback
    default:
        http_response_code(404);
        echo "404 Not Found: " . htmlspecialchars($uri);
}
<?php
date_default_timezone_set('Asia/Yangon');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../vendor/autoload.php';


use AdminController\PageController;
use AdminController\AuthController;
use AdminController\RecipeController;
use AdminController\UserController;
use AdminController\CulinaryTrendsController;
use AdminController\CookBookController;
use AdminController\EventController;
use AdminController\ResourceController;
use AdminController\TeamController;
use AdminController\ContactController;
use AdminController\ProfileController;

$adminPath = '/foodfusion/admin';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($adminPath, '', $uri);
$uri = rtrim($uri, '/') ?: '/'; // normalize root to "/"

$method = $_SERVER['REQUEST_METHOD'];
$PageController = new PageController();
$AuthController = new AuthController();
$UserController = new UserController();
$RecipeController = new RecipeController();
$CulinaryTrendsController = new CulinaryTrendsController();
$CookBookController = new CookBookController();
$ResourceController = new ResourceController();
$TeamController = new TeamController();
$EventController = new EventController();
$ContactController = new ContactController();
$ProfileController = new ProfileController();
//routing
 if ($uri === '/userView' && $method === 'GET')
{
    $PageController->userView();
}
else if ($uri === '/adminLogin' && $method === 'GET')
{
    $AuthController->adminLoginForm();
}
else if ($uri === '/adminLogin' && $method === 'POST')
{
    $AuthController->adminLoginProcess();
}
else if ($uri === '/adminRegister' && $method === 'GET')
{
    $AuthController->adminRegisterForm();
}
else if ($uri === '/adminRegister' && $method === 'POST')
{
    $AuthController->adminRegisterProcess();
}
else if ($uri === '/userList' && $method === 'GET')
{
    $UserController->userList();
}
else if ($uri === '/deleteUser' && $method === 'POST')
{
    $UserController->deleteUser();
}

else if ($uri == '/recipes' && $method === 'GET') {
    $RecipeController->recipes();
} 

 else if ($uri == '/postRecipe' && $method === 'GET') {
   $RecipeController->postRecipe();
} 


else if ($uri == '/postRecipe' && $method === 'POST') {
    $RecipeController->postRecipeProcess();
} 


else if ($uri == '/editRecipe' && $method === 'GET') {
    $RecipeController->editRecipe();
} 


else if ($uri == '/editRecipe' && $method === 'POST') {
    $RecipeController->editRecipeProcess();
}


else if ($uri == '/deleteRecipe' && $method === 'GET') {
    $RecipeController->deleteRecipe();
}

else if ($uri == '/toggleFeatured' && $method === 'POST') {
    $RecipeController->toggleFeatured();
}

else if ($uri === '/postCulinaryTrends' && $method === 'GET') {
    $CulinaryTrendsController->postCulinaryTrends();
}


else if ($uri === '/postCulinaryTrends' && $method === 'POST') {
    $CulinaryTrendsController->postCulinaryTrendsProcess();
}   


else if ($uri === '/culinaryTrends' && $method === 'GET')
{
    $CulinaryTrendsController->CulinaryTrends();
}
else if ($uri === '/userRecipes' && $method === 'GET')
{
    $CookBookController->userRecipes();
}
else if ($uri == '/toggleApproved' && $method === 'POST') {
    $CookBookController->toggleApproved();
}
else if ($uri == '/' && $method === 'GET') {
    $PageController->home();
}
else if ($uri == '/deleteCookbook' && $method === 'POST') {
    $CookBookController->deleteRecipe();
}

else if ($uri == '/Tips' && $method === 'GET') {
    $CookBookController->Tips();
}
else if ($uri == '/deleteTip' && $method === 'POST') {
    $CookBookController->deleteTip();
}
else if ($uri == '/deleteExp' && $method === 'POST') {
    $CookBookController->deleteExp();
}
else if ($uri == '/tiptoggleApproved' && $method === 'POST') {
    $CookBookController->tiptoggleApproved();
}
else if ($uri == '/exptoggleApproved' && $method === 'POST') {
    $CookBookController->exptoggleApproved();
}


else if ($uri == '/cookingTutorials' && $method === 'GET') {
    $ResourceController->cookingTutorials();
}
else if ($uri == '/postCookingTutorial' && $method === 'GET') {
    $ResourceController->postCookingTutorial();
}
else if ($uri == '/postCookingTutorial' && $method === 'POST') {
    $ResourceController->postCookingTutorialProcess();
}
else if ($uri == '/hacks' && $method === 'GET') {
    $ResourceController->hacks();
}
else if ($uri == '/postHacks' && $method === 'GET') {
    $ResourceController->postHacks();
}
else if ($uri == '/postHacks' && $method === 'POST') {
    $ResourceController->postHacksProcess();
}
else if ($uri == '/postEduResources' && $method === 'GET') {
    $ResourceController->postEduResources();
}

else if ($uri == '/postEduResources' && $method === 'POST') {
    $ResourceController->postEduResourcesProcess();
}
else if ($uri == '/createTeamMember' && $method === 'GET') {
    $TeamController->createForm();
}


else if ($uri == '/createTeamMember' && $method === 'POST') {
    $TeamController->createProcess();
}

else if ($uri == '/editTeamMember' && $method === 'GET') {
    $TeamController->edit();
}


else if ($uri == '/editTeamMember' && $method === 'POST') {
    $TeamController->editProcess();
}


else if ($uri == '/teamList' && $method === 'GET') {
    $TeamController->list();
}

else if ($uri == '/deleteMember' && $method === 'POST') {
    $TeamController->deleteMember();
}

else if ($uri == '/editCulinaryTrend' && $method === 'GET') {
    $CulinaryTrendsController->editCulinaryTrend();
}
else if ($uri == '/editCulinaryTrend' && $method === 'POST') {
    $CulinaryTrendsController->editCulinaryTrendProcess();
}
else if ($uri == '/deleteCulinaryTrend' && $method === 'POST') {
    $CulinaryTrendsController->delete();
}
else if ($uri == '/eventList' && $method === 'GET') {
    $EventController->eventList();
}
else if ($uri == '/createEvent' && $method === 'GET') {
    $EventController->createForm();
}
else if ($uri == '/createEvent' && $method === 'POST') {
    $EventController->createEventProcess();
}

else if ($uri == '/deleteEvent' && $method === 'POST') {
    $EventController->deleteEvent();
}


else if ($uri == '/editEvent' && $method === 'GET') {
    $EventController->editForm();
}


else if ($uri == '/editEventProcess' && $method === 'POST') {
    $EventController->editEventProcess();
}


else if ($uri == '/editEdu' && $method === 'GET') {
    $ResourceController->editForm();
}
else if ($uri == '/editHack' && $method === 'GET') {
    $ResourceController->editHackForm();
}
elseif (preg_match('#^/updateEduResource/(\d+)$#', $uri, $matches) && $method === 'POST') {
    $ResourceController->updateResource($matches[1]);
}
elseif (preg_match('#^/updateHack/(\d+)$#', $uri, $matches) && $method === 'POST') {
    $ResourceController->updateHack($matches[1]);
}
else if ($uri == '/eduResources' && $method === 'GET') {
    $ResourceController->eduResources();
}
else if ($uri == '/experiences' && $method === 'GET') {
    $CookBookController->experiences();
}
elseif ($uri === '/messages' && $method === 'GET') {
    $ContactController->messages();
}
elseif ($uri === '/deleteEdu' && $method === 'GET') {
    $ResourceController->deleteEdu();
}
elseif ($uri === '/deleteHack' && $method === 'GET') {
    $ResourceController->deleteHack();
}
elseif ($uri === '/cookingTutorials' && $method === 'GET') {
    $ResourceController->cookingTutorials();

} elseif ($uri === '/editTutorial' && $method === 'GET') {
    $ResourceController->editTutorialForm();

} elseif ($uri === '/updateTutorial' && $method === 'POST') {
    $ResourceController->updateTutorialProcess();
}
elseif ($uri === '/deleteTutorial' && $method === 'GET') {
    $ResourceController->deleteTutorial();
}
// Show recipe card list
elseif ($uri === '/recipeCardList' && $method === 'GET') {
    $ResourceController->recipeCardList();
}
// Show create recipe card form
elseif ($uri === '/postRecipeCard' && $method === 'GET') {
    $ResourceController->postRecipeCardForm();
}
// Handle create recipe card submission
elseif ($uri === '/postRecipeCard' && $method === 'POST') {
    $ResourceController->postRecipeCardProcess();
}
// Show edit recipe card form
elseif ($uri === '/editRecipeCard' && $method === 'GET') {
    $ResourceController->editRecipeCardForm();
}
// Handle recipe card update submission
elseif ($uri === '/updateRecipeCard' && $method === 'POST') {
    $ResourceController->updateRecipeCardProcess();
}

// Handle delete recipe card
elseif ($uri === '/deleteRecipeCard' && $method === 'GET') {
    $ResourceController->deleteRecipeCard();
}
elseif ($uri === '/profile' && $method === 'GET') {
    $ProfileController->viewProfile();
}
elseif ($uri === '/profile' && $method === 'POST') {
    $ProfileController->updateProfile();
}
elseif ($uri === '/logout' && $method === 'GET') {
    $ProfileController->logout();
}
elseif ($uri === '/deleteAccount' && $method === 'POST') {
    $ProfileController->delete();
}
elseif ($uri === '/infoList' && $method === 'GET') {
    $ResourceController->infoList();
}
elseif ($uri === '/postInfo' && $method === 'GET') {
    $ResourceController->postInfo();
}
elseif ($uri === '/postInfo' && $method === 'POST') {
    $ResourceController->postInfoProcess();
}
elseif ($uri === '/editInfo' && $method === 'GET' && isset($_GET['id'])) {
    $ResourceController->editInfoForm($_GET['id']);
}
elseif ($uri === '/editInfo' && $method === 'POST' && isset($_GET['id'])) {
    $ResourceController->updateInfoProcess($_GET['id']);
}
elseif ($uri === '/deleteInfo' && $method === 'GET' && isset($_GET['id'])) {
    $ResourceController->deleteInfo($_GET['id']);
}


else {
    http_response_code(404);
    echo "404 Not Found: " . htmlspecialchars($uri);
}
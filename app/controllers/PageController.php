<?php
namespace Controller;

use AdminModel\Admin;
use AdminModel\Recipe;
use Model\User;
use Model\Recipe as UserRecipe;
use Model\Trend;
use AdminModel\Event;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class PageController {

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

    public function home() {
        $usermodel = new User();
        $trendModel = new Trend();
        $recipeModel = new UserRecipe();
        $eventModel = new Event();
        $featuredRecipes = $recipeModel->getFeaturedRecipes();
        $trends = $trendModel->getAll();
        $events = $eventModel->getAllEvents();
        extract($this->getUserData());
        include_once __DIR__ . '/../views/pages/home.php';
    }

    public function cookiePolicy() {
        $this->render('cookiePolicy');
    }


    public function aboutUs() {
        $usermodel = new User();
        $members = $usermodel->getMembers();
        extract($this->getUserData());
        include_once __DIR__ . '/../views/pages/aboutUs.php';
    }


    public function terms() {
        $this->render('terms');
    }

    public function privacy() {
        $this->render('privacy');
    }
    

}
?>
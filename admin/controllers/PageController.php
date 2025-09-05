<?php
namespace AdminController;

use AdminModel\Admin;

class PageController {
   

    public function userView() {
        header("Location: /foodfusion/public/");
    }
    public function home() {
    $adminModel = new Admin();
    $userCount = $adminModel->getUserCount();
    $recipeCount = $adminModel->getRecipeCount();
    $messageCount = $adminModel->getContactMessageCount();
    $upcomingEvents = $adminModel->getUpcomingEvents();
    $recentRecipes = $adminModel->getRecentRecipes();
        include_once __DIR__ . '/../views/pages/dashboard.php';
}

   

}
?>
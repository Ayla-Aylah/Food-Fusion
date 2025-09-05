<?php
namespace AdminController;

use AdminModel\CookBook;

class CookBookController{
    public function userRecipes(){
        $recipe = new CookBook();
        $recipes = $recipe->getAllRecipes();
        include_once __DIR__.'/../views/pages/userRecipes.php';
    }
    
public function toggleApproved()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recipeId = $_POST['recipe_id'] ?? null;
        $isApproved = $_POST['is_approved'] ?? null;

        if ($recipeId && ($isApproved === '0' || $isApproved === '1')) {
            $cookbookmodel = new CookBook();
            $result = $cookbookmodel->toggleApproved($recipeId, $isApproved);

            if ($result) {
                $_SESSION['success'] = 'Recipe Approved status updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update recipe approved status.';
            }
        } else {
            $_SESSION['error'] = 'Invalid request data.';
        }
        header("Location: /foodfusion/admin/userRecipes");
        exit;
    }
}

public function tiptoggleApproved()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tip_id = $_POST['tip_id'] ?? null;
        $isApproved = $_POST['is_approved'] ?? null;

        if ($tip_id && ($isApproved === '0' || $isApproved === '1')) {
            $cookbookmodel = new CookBook();
            $result = $cookbookmodel->tiptoggleApproved($tip_id, $isApproved);

            if ($result) {
                $_SESSION['success'] = 'Recipe Approved status updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update recipe approved status.';
            }
        } else {
            $_SESSION['error'] = 'Invalid request data.';
        }

        // Redirect back
        header("Location: /foodfusion/admin/Tips");
        exit;
    }
}

public function exptoggleApproved()
{
        $id = $_POST['id'] ?? null;
        $isApproved = $_POST['is_approved'] ?? null;
 
        if ($id && ($isApproved === '0' || $isApproved === '1')) {
            $cookbookmodel = new CookBook();
            $result = $cookbookmodel->exptoggleApproved($id, $isApproved);

            if ($result) {
                $_SESSION['success'] = 'Experience Approved status updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update experience approved status.';
            }
        } else {
            $_SESSION['error'] = 'Invalid experience data.';
        }

        // Redirect back
        header("Location: /foodfusion/admin/experiences");
        exit;
    }

public function Tips(){
        $cookbookmodel = new CookBook();
        $tips = $cookbookmodel->getAllTips();
        include_once __DIR__.'/../views/pages/culinaryTips.php';
}

public function experiences(){
        $cookbookmodel = new CookBook();
        $experiences = $cookbookmodel->getAllexp();
        include_once __DIR__.'/../views/pages/experienceList.php';
}


public function deleteRecipe()
{
   if (!isset($_POST['id']) || empty($_POST['id'])) {
    $_SESSION['error'] = 'Invalid recipe ID.';
    header('Location: /foodfusion/admin/userRecipes');
    exit;
}

    $id = intval($_POST['id']);
    $recipes = new CookBook();
    
    $recipe = $recipes->getRecipeById($id); // now $recipe is an array

    if ($recipe && !empty($recipe['image_path']) && file_exists(__DIR__ . '/../../public/' . $recipe['image_path'])) {
        unlink(__DIR__ . '/../../public/' . $recipe['image_path']);
    }

    $recipes->deleteRecipeIngredients($id);
    $recipes->deleteRecipeInstructions($id);
    $recipes->deletelikes($id);
    $recipes->deleteRecipe($id); 

    if ($recipes->deleteRecipe($id)) {
        $_SESSION['success'] = 'Recipe deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete recipe.';
    }

    header('Location: /foodfusion/admin/userRecipes');
    exit;
}


public function deleteTip()
{
   if (!isset($_POST['id']) || empty($_POST['id'])) {
    $_SESSION['error'] = 'Invalid tip ID.';
    header('Location: /foodfusion/admin/Tips');
    exit;
}

    $id = intval($_POST['id']);
    $cookbookmodel = new CookBook();
    
    $tip = $cookbookmodel->getTipByID($id); // now $recipe is an array

    if ($tip && !empty($tip['image_path']) && file_exists(__DIR__ . '/../../public/' . $tip['image_path'])) {
        unlink(__DIR__ . '/../../public/' . $tip['image_path']);
    }
    
    $cookbookmodel->deleteTip($id); 

    if ($cookbookmodel->deleteTip($id)) {
        $_SESSION['success'] = 'tips deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete recipe.';
    }

    header('Location: /foodfusion/admin/Tips');
    exit;
}

public function deleteExp()
{
   if (!isset($_POST['id']) || empty($_POST['id'])) {
    $_SESSION['error'] = 'Invalid experience ID.';
    header('Location: /foodfusion/admin/experiences');
    exit;
}

    $id = intval($_POST['id']);
    $cookbookmodel = new CookBook();
    
    $exp = $cookbookmodel->getExpByID($id); // now $recipe is an array

    if ($exp && !empty($exp['image_path']) && file_exists(__DIR__ . '/../../public/' . $exp['image_path'])) {
        unlink(__DIR__ . '/../../public/' . $exp['image_path']);
    }
    
    $cookbookmodel->deleteExp($id); 

    if ($cookbookmodel->deleteExp($id)) {
        $_SESSION['success'] = 'experiences deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete recipe.';
    }

    header('Location: /foodfusion/admin/experiences');
    exit;
}
}

?>
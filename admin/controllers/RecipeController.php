<?php
namespace AdminController;

use AdminModel\Recipe;

Class RecipeController {

    public function recipes()
    {
        $recipe = new Recipe();
        $recipes = $recipe->getAllRecipes();
        include_once __DIR__.'/../views/pages/recipes.php';
    }

    public function postRecipe()
    {
        include_once __DIR__.'/../views/pages/postRecipe.php';
    }


    public function postRecipeProcess()
    {
    $recipe = new Recipe();

    // Collect form data
    $data = [
        'recipe_title'        => trim($_POST['recipe_title'] ?? ''),
        'recipe_description'  => trim($_POST['recipe_description'] ?? ''),
        'recipe_tips'         => trim($_POST['recipe_tips'] ?? ''),
        'nutrition'           => trim($_POST['nutrition'] ?? ''),
        'cuisine'             => trim($_POST['cuisine'] ?? ''),
        'diet'                => trim($_POST['diet'] ?? ''),
        'difficulty'          => trim($_POST['difficulty'] ?? ''),
        'cooking_time'        => trim($_POST['cooking_time'] ?? '')
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
        header('Location: /foodfusion/admin/postRecipe');
        exit;
    }

    // Upload recipe image
    $uploadResult = $recipe->uploadRecipePhoto('recipe_photo');
    if (isset($uploadResult['error'])) {
        $_SESSION['error'] = ['recipe_photo' => $uploadResult['error']];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/admin/postRecipe');
        exit;
    }

    // Add image path to recipe data
    $data['recipe_photo'] = $uploadResult['path'];

    // Insert main recipe and capture its ID
    $recipeId = $recipe->postRecipe($data);
    if (!$recipeId) {
        $_SESSION['error'] = ['recipe' => 'Failed to insert recipe.'];
        $_SESSION['old']   = $_POST;
        header('Location: /foodfusion/admin/postRecipe');
        exit;
    }

    // Insert ingredients
    foreach ($_POST['ingredient_name'] as $index => $name) {
        if (!empty(trim($name))) {
            $quantity = $_POST['quantity'][$index] ?? '';
            $unit     = $_POST['unit'][$index] ?? '';
            $recipe->addRecipeIngredient($recipeId, $name, $quantity, $unit);
        }
    }
    // Insert instructions
    foreach ($_POST['step_number'] as $index => $stepNum) {
        $stepText = $_POST['step_text'][$index] ?? '';
        if (!empty(trim($stepText))) {
            $recipe->addRecipeInstruction($recipeId, $stepNum, $stepText);
        }
    }

    // Success message & redirect
    $_SESSION['success'] = 'Recipe posted successfully!';
    header('Location: /foodfusion/admin/recipes');
    exit;
}

public function editRecipe(){
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error'] = 'Invalid recipe ID.';
        header('Location: /foodfusion/admin/recipes');
        exit;
    }
    $recipeId = intval($_GET['id']);
    $recipe = new Recipe();

    $old = $recipe->getRecipeById($recipeId);
    $ingredients = $recipe->getRecipeIngredients($recipeId);
    $instructions = $recipe->getRecipeInstructions($recipeId);
    
    if (!$old) {
        $_SESSION['error'] = 'Recipe not found.';
        header('Location: /foodfusion/admin/recipes');
        exit;
    }
    include_once __DIR__.'/../views/pages/editRecipe.php';
}

public function editRecipeProcess()
{
    $recipe = new Recipe();
    $recipeId = $_POST['recipe_id'] ?? null;
    if (!$recipeId || !$recipe->getRecipeById($recipeId)) {
        $_SESSION['error'] = 'Invalid recipe ID.';
        header('Location: /foodfusion/admin/recipes');
        exit;
    }

    // Collect form data
    $data = [
        'recipe_id'          => $recipeId,
        'recipe_title'       => trim($_POST['recipe_title'] ?? ''),
        'recipe_description' => trim($_POST['recipe_description'] ?? ''),
        'recipe_tips'        => trim($_POST['recipe_tips'] ?? ''),
        'nutrition'          => trim($_POST['nutrition'] ?? ''),
        'cuisine'            => trim($_POST['cuisine'] ?? ''),
        'diet'               => trim($_POST['diet'] ?? ''),
        'difficulty'         => trim($_POST['difficulty'] ?? ''),
        'cooking_time'       => trim($_POST['cooking_time'] ?? '')
    ];

    //  Validate required fields
    $errors = [];

    foreach ($data as $key => $value) {
        if ($key !== 'recipe_id' && empty($value)) {
            $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required.';
        }
    }

    // Validate ingredients and instructions
    $ingredientNames = $_POST['ingredient_name'] ?? [];
    $quantities      = $_POST['quantity'] ?? [];
    $units           = $_POST['unit'] ?? [];

    $stepNumbers     = $_POST['step_number'] ?? [];
    $stepTexts       = $_POST['step_text'] ?? [];

    if (empty($ingredientNames) || !is_array($ingredientNames)) {
        $errors['ingredients'] = 'Please add at least one ingredient.';
    }

    if (empty($stepTexts) || !is_array($stepTexts)) {
        $errors['instructions'] = 'Please add at least one instruction.';
    }

    // Return back if errors
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old']   = $_POST;
        header("Location: /foodfusion/admin/editRecipe");
        exit;
    }

    // Handle image upload if provided
    if (!empty($_FILES['recipe_photo']['name'])) {
        // Only call uploadRecipePhoto() if a new file is selected AND no upload error
        if ($_FILES['recipe_photo']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $recipe->uploadRecipePhoto('recipe_photo');

            if (isset($uploadResult['error'])) {
                $_SESSION['error'] = ['recipe_photo' => $uploadResult['error']];
                $_SESSION['old']   = $_POST;
                header("Location: /foodfusion/admin/editRecipe/$recipeId");
                exit;
            }

            $data['recipe_photo'] = $uploadResult['path'];
        } else {
            $_SESSION['error'] = ['recipe_photo' => 'Image upload failed.'];
            $_SESSION['old']   = $_POST;
            header("Location: /foodfusion/admin/editRecipe/$recipeId");
            exit;
        }
    } else {
        // No new file selected — keep the old one
        $existing = $recipe->getRecipeById($recipeId);
        $data['recipe_photo'] = $existing['image_path'] ?? '';
    }

    // Update main recipe data
    if (!$recipe->updateRecipe($data)) {
        $_SESSION['error'] = ['recipe' => 'Failed to update recipe.'];
        $_SESSION['old']   = $_POST;
        header("Location: /foodfusion/admin/editRecipe/$recipeId");
        exit;
    }

    // Update ingredients
    $recipe->deleteRecipeIngredients($recipeId);
    foreach ($ingredientNames as $index => $name) {
        $name = trim($name);
        if ($name !== '') {
            $quantity = $quantities[$index] ?? '';
            $unit     = $units[$index] ?? '';
            $recipe->addRecipeIngredient($recipeId, $name, $quantity, $unit);
        }
    }

    // Update instructions
    $recipe->deleteRecipeInstructions($recipeId);
    foreach ($stepTexts as $index => $stepText) {
        $stepText = trim($stepText);
        if ($stepText !== '') {
            $stepNum = $stepNumbers[$index] ?? ($index + 1);
            $recipe->addRecipeInstruction($recipeId, $stepNum, $stepText);
        }
    }

    // Redirect to success
    $_SESSION['success'] = 'Recipe updated successfully!';
    header('Location: /foodfusion/admin/recipes');
    exit;
}


public function deleteRecipe()
{
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error'] = 'Invalid recipe ID.';
        header('Location: /foodfusion/admin/recipes');
        exit;
    }

    $id = intval($_GET['id']);
    $recipes = new Recipe();
    
    $recipe = $recipes->getRecipeById($id); // now $recipe is an array

    if ($recipe && !empty($recipe['image_path']) && file_exists(__DIR__ . '/../../public/' . $recipe['image_path'])) {
        unlink(__DIR__ . '/../../public/' . $recipe['image_path']);
    }

    $recipes->deleteRecipeIngredients($id);
    $recipes->deleteRecipeInstructions($id);
    $recipes->deleteRecipe($id); // then delete the recipe using model

    if ($recipes->deleteRecipe($id)) {
        $_SESSION['success'] = 'Recipe deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete recipe.';
    }

    header('Location: /foodfusion/admin/recipes');
    exit;
}
public function toggleFeatured()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recipeId = $_POST['recipe_id'] ?? null;
        $isFeatured = $_POST['is_featured'] ?? null;

        if ($recipeId && ($isFeatured === '0' || $isFeatured === '1')) {
            $recipe = new Recipe();
            $result = $recipe->toggleFeatured($recipeId, $isFeatured);

            if ($result) {
                $_SESSION['success'] = 'Recipe featured status updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update recipe featured status.';
            }
        } else {
            $_SESSION['error'] = 'Invalid request data.';
        }

        // Redirect back
        header("Location: /foodfusion/admin/recipes");
        exit;
    }
}

}

?>
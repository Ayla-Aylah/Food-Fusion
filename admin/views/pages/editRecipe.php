<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
$errors = $_SESSION['error'] ?? [];
$form_old = $_SESSION['data'] ?? [];

unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe | FoodFusion </title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <section class="">
        <div class="min-h-screen flex items-center justify-center flex-col  px-4 sm:px-6 lg:px-8 ">
            <div class="container mx-auto mt-10 p-4">
                <h1 class="text-center text-2xl  text-[#111827]  font-bold mb-4">Edit Recipe</h1>
                <?php if (!empty($errors['recipePost'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['recipePost']) ?>
                </div>
                <?php endif;?>
            </div>
            <form action="/foodfusion/admin/editRecipe" method="POST" enctype="multipart/form-data" class=" bg-white p-6 w-full grid
                grid-cols-1 md:grid-cols-2">
                <input type="hidden" name="recipe_id" value="<?= $old['id'] ?>">
                <div class="flex flex-col items-center justify-start mr-5  ">
                    <div class=" mb-4 rounded-2xl shadow-md">
                        <!-- Current profile image -->
                        <?php if (!empty($old['image_path'])): ?>
                        <img class="w-100 h-100 object-cover rounded-2xl " id="recipePreview"
                            src="/foodfusion/public/<?= $old['image_path']; ?>" alt="Recipe Photo"
                            style="border-radius: 8px;">
                        <?php else: ?>
                        <img class="w-90 h-90 object-cover rounded-md" id="recipePreview"
                            src="/foodfusion/public/uploads/recipes/recipes.png" alt="Recipe" width="150">
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if (!empty($errors['recipe_photo'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['recipe_photo']) ?>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="recipe_photo" id="recipe_photo" class="hidden">

                        <!-- Custom upload button -->
                        <label for="recipe_photo"
                            class="inline-block bg-[#bef264] mx-10 mb-5 px-4 py-2 rounded-lg cursor-pointer hover:bg-[#f6ffe6] hover:text-gray-600 shadow-md duration-300 transition">
                            Upload Recipe Photo
                        </label>
                    </div>

                </div>

                <div>
                    <div class="mb-4">
                        <label for="recipe_title" class="block text-sm text-[#111827] font-medium">Recipe Title</label>
                        <?php if (!empty($errors['recipe_title'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['recipe_title']) ?>
                        </div>
                        <?php endif; ?>
                        <input type="text" name="recipe_title" id="recipe_title" placeholder="Enter recipe title"
                            class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] 
                            focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['recipe_title'])?htmlspecialchars($old['title']?? htmlspecialchars($form_old['recipe_title'])):''?>">
                    </div>

                    <div class="mb-4">
                        <label for="recipe_description"
                            class="block text-sm text-[#111827] font-medium">Description</label>
                        <?php if (!empty($errors['recipe_description'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['recipe_description']) ?>
                        </div>
                        <?php endif; ?>
                        <textarea type="text" rows="4" name="recipe_description" id="recipe_description"
                            placeholder="Enter recipe description"
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "><?= !empty($errors['recipe_description']) ? '' : htmlspecialchars($old['description'] ?? '') ?>
                        </textarea>
                    </div>
                    <!-- Ingredients Section -->
                    <div id="ingredientsContainer" class="mb-4">
                        <label class="block text-sm text-[#111827] font-medium">Ingredients</label>
                        <?php if (!empty($errors['ingredients'])): ?>
                        <div class="text-red-500 text-sm py-1">
                            <?= htmlspecialchars($errors['ingredients']) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($ingredients)): ?>
                        <?php foreach ($ingredients as $index => $ingredient): ?>
                        <div class="flex space-x-2 mb-2">
                            <input type="text" name="ingredient_name[]"
                                value="<?= htmlspecialchars($ingredient['ingredient_name']) ?>" placeholder="Ingredient"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="quantity[]"
                                value="<?= htmlspecialchars($ingredient['quantity']) ?>" placeholder="Quantity"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="unit[]" value="<?= htmlspecialchars($ingredient['unit']) ?>"
                                placeholder="Unit"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <button type="button" onclick="addIngredient()"
                                class="bg-green-500 text-white px-3 rounded-md shadow-md hover:bg-green-100">+</button>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <!-- Show one blank row if no ingredients -->
                        <div class="flex space-x-2 mb-2">
                            <input type="text" name="ingredient_name[]" placeholder="Ingredient"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="quantity[]" placeholder="Quantity"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="unit[]" placeholder="Unit"
                                class="flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]">
                            <button type="button" onclick="addIngredient()"
                                class="bg-green-500 text-white px-3 rounded-md shadow-md hover:bg-green-100">+</button>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Instruction Container -->
                    <div id="instructionsContainer" class="mb-4">
                        <label class="block text-sm text-[#111827] font-medium">Instructions</label>
                        <?php if (!empty($errors['instructions'])): ?>
                        <div class="text-red-500 text-sm py-1">
                            <?= htmlspecialchars($errors['instructions']) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($instructions)): ?>
                        <?php foreach ($instructions as $index => $instruction): ?>
                        <div class="flex space-x-2 mb-2">
                            <input type="number" name="step_number[]"
                                value="<?= htmlspecialchars($instruction['step_number']) ?>" placeholder="Step #"
                                class="flex items-center rounded-md bg-white p-2 w-1/3 outline-1 outline-[#16a34a]">
                            <textarea name="step_text[]" placeholder="Instruction"
                                class="resize-none flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]"><?= htmlspecialchars($instruction['step_text']) ?></textarea>
                            <button type="button" onclick="addInstruction()"
                                class="bg-green-500 text-white px-3 rounded-md shadow-md hover:bg-green-100">+</button>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <!-- Show one blank row if no instructions -->
                        <div class="flex space-x-2 mb-2">
                            <input type="number" name="step_number[]" placeholder="Step #"
                                class="flex items-center rounded-md bg-white p-2 w-1/3 outline-1 outline-[#16a34a]">
                            <textarea name="step_text[]" placeholder="Instruction"
                                class="resize-none flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]"></textarea>
                            <button type="button" onclick="addInstruction()"
                                class="bg-green-500 text-white px-3 rounded-md shadow-md hover:bg-green-100">+</button>
                        </div>
                        <?php endif; ?>
                    </div>


                    <div class="mb-4">
                        <label for="recipe_tips" class="block text-sm text-[#111827] font-medium">
                            Tips</label>
                        <?php if (!empty($errors['recipe_tips'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['recipe_tips']) ?>
                        </div>
                        <?php endif; ?>
                        <textarea type="text" rows="4" name="recipe_tips" id="recipe_tips"
                            placeholder="Enter recipe tips"
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "><?= !empty($errors['recipe_tips']) ? '' : htmlspecialchars($old['recipe_tips'] ?? '') ?></textarea>
                    </div>


                    <div class="mb-4">
                        <label for="nutrition" class="block text-sm text-[#111827] font-medium">
                            Nutrition</label>
                        <?php if (!empty($errors['nutrition'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['nutrition']) ?>
                        </div>
                        <?php endif; ?>
                        <textarea type="text" rows="4" name="nutrition" id="nutrition"
                            placeholder="Enter recipe nutrition information"
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['nutrition'])?htmlspecialchars($old['nutrition']?? ''):''?>"><?= !empty($errors['nutrition']) ? '' : htmlspecialchars($old['nutrition'] ?? '') ?></textarea>
                    </div>


                    <div class="mb-5"> <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine
                            Type</label>
                        <?php if (!empty($errors['cuisine'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['cuisine']) ?>
                        </div>
                        <?php endif; ?>
                        <select id="cuisine" name="cuisine"
                            class="block w-full p-2 border border-green-500 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 focus-within:outline-[#bef264] text-sm text-gray-700">
                            <option value="" disabled selected>Select cuisine type</option>

                            <option value="Global" <?= $old['cuisine_type'] === 'Global' ? 'selected' : '' ?>>Global
                            </option>
                            <optgroup label="Asian Cuisines">
                                <option value="Asian" <?= $old['cuisine_type'] === 'Asian' ? 'selected' : '' ?>>Asian
                                </option>
                                <option value="Afghan" <?= $old['cuisine_type'] === 'Afghan' ? 'selected' : '' ?>>Afghan
                                </option>
                                <option value="Bangladeshi"
                                    <?= $old['cuisine_type'] === 'Bangladeshi' ? 'selected' : '' ?>>Bangladeshi
                                </option>
                                <option value="Burmese" <?= $old['cuisine_type'] === 'Burmese' ? 'selected' : '' ?>>
                                    Burmese</option>
                                <option value="Cambodian" <?= $old['cuisine_type'] === 'Cambodian' ? 'selected' : '' ?>>
                                    Cambodian</option>
                                <option value="Chinese" <?= $old['cuisine_type'] === 'Chinese' ? 'selected' : '' ?>>
                                    Chinese</option>
                                <option value="Filipino" <?= $old['cuisine_type'] === 'Filipino' ? 'selected' : '' ?>>
                                    Filipino</option>
                                <option value="Indian" <?= $old['cuisine_type'] === 'Indian' ? 'selected' : '' ?>>Indian
                                </option>
                                <option value="Indonesian"
                                    <?= $old['cuisine_type'] === 'Indonesian' ? 'selected' : '' ?>>Indonesian</option>
                                <option value="Japanese" <?= $old['cuisine_type'] === 'Japanese' ? 'selected' : '' ?>>
                                    Japanese</option>
                                <option value="Korean" <?= $old['cuisine_type'] === 'Korean' ? 'selected' : '' ?>>Korean
                                </option>
                                <option value="Laotian" <?= $old['cuisine_type'] === 'Loatian' ? 'selected' : '' ?>>
                                    Laotian</option>
                                <option value="Malaysian" <?= $old['cuisine_type'] === 'Malaysian' ? 'selected' : '' ?>>
                                    Malaysian</option>
                                <option value="Mongolian" <?= $old['cuisine_type'] === 'Mongolian' ? 'selected' : '' ?>>
                                    Mongolian</option>
                                <option value="Nepalese" <?= $old['cuisine_type'] === 'Nepalese' ? 'selected' : '' ?>>
                                    Nepalese</option>
                                <option value="Pakistani" <?= $old['cuisine_type'] === 'Pakistani' ? 'selected' : '' ?>>
                                    Pakistani</option>
                                <option value="Sri Lankan"
                                    <?= $old['cuisine_type'] === 'Sri Lankan' ? 'selected' : '' ?>>
                                    Sri Lankan</option>
                                <option value="Taiwanese" <?= $old['cuisine_type'] === 'Taiwanese' ? 'selected' : '' ?>>
                                    Taiwanese</option>
                                <option value="Thai" <?= $old['cuisine_type'] === 'Thai' ? 'selected' : '' ?>>Thai
                                </option>
                                <option value="Vietnamese"
                                    <?= $old['cuisine_type'] === 'Vietnamese' ? 'selected' : '' ?>>
                                    Vietnamese</option>
                            </optgroup>

                            <optgroup label="European Cuisines">
                                <option value="European" <?= $old['cuisine_type'] === 'European' ? 'selected' : '' ?>>
                                    European</option>
                                <option value="British" <?= $old['cuisine_type'] === 'British' ? 'selected' : '' ?>>
                                    British</option>
                                <option value="Bulgarian" <?= $old['cuisine_type'] === 'Bulgarian' ? 'selected' : '' ?>>
                                    Bulgarian</option>
                                <option value="Croatian" <?= $old['cuisine_type'] === 'Croatian' ? 'selected' : '' ?>>
                                    Croatian</option>
                                <option value="Czech" <?= $old['cuisine_type'] === 'Czech' ? 'selected' : '' ?>>Czech
                                </option>
                                <option value="Dutch" <?= $old['cuisine_type'] === 'Dutch' ? 'selected' : '' ?>>Dutch
                                </option>
                                <option value="Finnish" <?= $old['cuisine_type'] === 'Finnish' ? 'selected' : '' ?>>
                                    Finnish</option>
                                <option value="French" <?= $old['cuisine_type'] === 'French' ? 'selected' : '' ?>>
                                    French</option>
                                <option value="German" <?= $old['cuisine_type'] === 'German' ? 'selected' : '' ?>>
                                    German</option>
                                <option value="Greek" <?= $old['cuisine_type'] === 'Greek' ? 'selected' : '' ?>>Greek
                                </option>
                                <option value="Hungarian" <?= $old['cuisine_type'] === 'Hungarian' ? 'selected' : '' ?>>
                                    Hungarian</option>
                                <option value="Irish" <?= $old['Irish'] === 'Irish' ? 'selected' : '' ?>>Irish
                                </option>
                                <option value="Italian" <?= $old['cuisine_type'] === 'Italian' ? 'selected' : '' ?>>
                                    Italian</option>
                                <option value="Polish" <?= $old['cuisine_type'] === 'Polish' ? 'selected' : '' ?>>
                                    Polish</option>
                                <option value="Portuguese"
                                    <?= $old['cuisine_type'] === 'Portuguese' ? 'selected' : '' ?>>
                                    Portuguese</option>
                                <option value="Romanian" <?= $old['cuisine_type'] === 'Romanian' ? 'selected' : '' ?>>
                                    Romanian</option>
                                <option value="Russian" <?= $old['cuisine_type'] === 'Russian' ? 'selected' : '' ?>>
                                    Russian</option>
                                <option value="Spanish" <?= $old['cuisine_type'] === 'Spanish' ? 'selected' : '' ?>>
                                    Spanish</option>
                                <option value="Swedish" <?= $old['cuisine_type'] === 'Swedish' ? 'selected' : '' ?>>
                                    Swedish</option>
                                <option value="Swiss" <?= $old['cuisine_type'] === 'Swiss' ? 'selected' : '' ?>>Swiss
                                </option>
                                <option value="Turkish" <?= $old['cuisine_type'] === 'Turkish' ? 'selected' : '' ?>>
                                    Turkish</option>
                                <option value="Ukrainian" <?= $old['cuisine_type'] === 'Ukrainian' ? 'selected' : '' ?>>
                                    Ukrainian</option>
                            </optgroup>

                            <optgroup label="Middle Eastern & African Cuisines">
                                <option value="Africa" <?= $old['cuisine_type'] === 'Africa' ? 'selected' : '' ?>>
                                    African</option>
                                <option value="Middle Eastern"
                                    <?= $old['cuisine_type'] === 'Middle Eastern' ? 'selected' : '' ?>>Middle Eastern
                                </option>
                                <option value="Algerian" <?= $old['cuisine_type'] === 'Algerian' ? 'selected' : '' ?>>
                                    Algerian</option>
                                <option value="Egyptian" <?= $old['cuisine_type'] === 'Egyptian' ? 'selected' : '' ?>>
                                    Egyptian</option>
                                <option value="Ethiopian" <?= $old['cuisine_type'] === 'Ethiopian' ? 'selected' : '' ?>>
                                    Ethiopian</option>
                                <option value="Iranian" <?= $old['cuisine_type'] === 'Iranian' ? 'selected' : '' ?>>
                                    Iranian</option>
                                <option value="Iraqi" <?= $old['cuisine_type'] === 'Iraqi' ? 'selected' : '' ?>>Iraqi
                                </option>
                                <option value="Israeli" <?= $old['cuisine_type'] === 'Israeli' ? 'selected' : '' ?>>
                                    Israeli</option>
                                <option value="Jordanian" <?= $old['cuisine_type'] === 'Jordanian' ? 'selected' : '' ?>>
                                    Jordanian</option>
                                <option value="Lebanese" <?= $old['cuisine_type'] === 'Lebanese' ? 'selected' : '' ?>>
                                    Lebanese</option>
                                <option value="Libyan" <?= $old['cuisine_type'] === 'Libyan' ? 'selected' : '' ?>>Libyan
                                </option>
                                <option value="Moroccan" <?= $old['cuisine_type'] === 'Moroccan' ? 'selected' : '' ?>>
                                    Moroccan</option>
                                <option value="Palestinian"
                                    <?= $old['cuisine_type'] === 'Palestinian' ? 'selected' : '' ?>>Palestinian</option>
                                <option value="Saudi Arabian"
                                    <?= $old['cuisine_type'] === 'Saudi Arabian' ? 'selected' : '' ?>>Saudi Arabian
                                </option>
                                <option value="Somali" <?= $old['cuisine_type'] === 'Somali' ? 'selected' : '' ?>>Somali
                                </option>
                                <option value="Sudanese" <?= $old['cuisine_type'] === 'Sudanese' ? 'selected' : '' ?>>
                                    Sudanese</option>
                                <option value="Syrian" <?= $old['cuisine_type'] === 'Syrian' ? 'selected' : '' ?>>Syrian
                                </option>
                                <option value="Tunisian" <?= $old['cuisine_type'] === 'Tunisian' ? 'selected' : '' ?>>
                                    Tunisian</option>
                                <option value="Yemeni" <?= $old['cuisine_type'] === 'Yemeni' ? 'selected' : '' ?>>Yemeni
                                </option>
                                <option value="South African"
                                    <?= $old['cuisine_type'] === 'South African' ? 'selected' : '' ?>>South African
                                </option>
                                <option value="Nigerian" <?= $old['cuisine_type'] === 'Nigerian' ? 'selected' : '' ?>>
                                    Nigerian</option>
                                <option value="Ghanaian" <?= $old['cuisine_type'] === 'Ghanaian' ? 'selected' : '' ?>>
                                    Ghanaian</option>
                            </optgroup>

                            <optgroup label="American & Latin Cuisines">
                                <option value="Latin" <?= $old['cuisine_type'] === 'Latin' ? 'selected' : '' ?>>Latin
                                </option>
                                <option value="American" <?= $old['cuisine_type'] === 'American' ? 'selected' : '' ?>>
                                    American</option>
                                <option value="Argentinian"
                                    <?= $old['cuisine_type'] === 'Argentinian' ? 'selected' : '' ?>>
                                    Argentinian</option>
                                <option value="Brazilian" <?= $old['cuisine_type'] === 'Brazilian' ? 'selected' : '' ?>>
                                    Brazilian</option>
                                <option value="Caribbean" <?= $old['cuisine_type'] === 'Caribbean' ? 'selected' : '' ?>>
                                    Caribbean</option>
                                <option value="Chilean" <?= $old['cuisine_type'] === 'Chilean' ? 'selected' : '' ?>>
                                    Chilean</option>
                                <option value="Colombian" <?= $old['cuisine_type'] === 'Colombian' ? 'selected' : '' ?>>
                                    Colombian</option>
                                <option value="Cuban" <?= $old['cuisine_type'] === 'Cuban' ? 'selected' : '' ?>>Cuban
                                </option>
                                <option value="Dominican" <?= $old['cuisine_type'] === 'Dominican' ? 'selected' : '' ?>>
                                    Dominican</option>
                                <option value="Haitian" <?= $old['cuisine_type'] === 'Haitian' ? 'selected' : '' ?>>
                                    Haitian</option>
                                <option value="Jamaican" <?= $old['cuisine_type'] === 'Jamaican' ? 'selected' : '' ?>>
                                    Jamaican</option>
                                <option value="Mexican" <?= $old['cuisine_type'] === 'Mexican' ? 'selected' : '' ?>>
                                    Mexican</option>
                                <option value="Peruvian" <?= $old['cuisine_type'] === 'Peruvian' ? 'selected' : '' ?>>
                                    Peruvian</option>
                                <option value="Puerto Rican"
                                    <?= $old['cuisine_type'] === 'Puerto Rican' ? 'selected' : '' ?>>Puerto Rican
                                </option>
                                <option value="Uruguayan" <?= $old['cuisine_type'] === 'Uruguayan' ? 'selected' : '' ?>>
                                    Uruguayan</option>
                                <option
                                    value="Venezuelan <?= $old['cuisine_type'] === 'Venezuelan' ? 'selected' : '' ?>">
                                    Venezuelan</option>
                            </optgroup>

                            <optgroup label="Oceanian Cuisines">
                                <option value="Oceanian" <?= $old['cuisine_type'] === 'Oceanian' ? 'selected' : '' ?>>
                                    Oceanian</option>
                                <option value="Australian"
                                    <?= $old['cuisine_type'] === 'Australian' ? 'selected' : '' ?>>Australian</option>
                                <option value="New Zealand"
                                    <?= $old['cuisine_type'] === 'New Zealand' ? 'selected' : '' ?>>New Zealand</option>
                                <option value="Polynesian"
                                    <?= $old['cuisine_type'] === 'Polynesian' ? 'selected' : '' ?>>
                                    Polynesian</option>
                                <option value="Hawaiian" <?= $old['cuisine_type'] === 'Hawaiian' ? 'selected' : '' ?>>
                                    Hawaiian</option>
                                <option value="Fijian" <?= $old['cuisine_type'] === 'Fijian' ? 'selected' : '' ?>>Fijian
                                </option>
                                <option value="Samoan" <?= $old['cuisine_type'] === 'Samoan' ? 'selected' : '' ?>>Samoan
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-5"> <label for="diet" class="block text-sm font-medium text-gray-700 mb-1">Dietary
                            Preference</label>
                        <?php if (!empty($errors['diet'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['diet']) ?>
                        </div>
                        <?php endif; ?>
                        <select id="diet" name="diet"
                            class="block w-full p-2 border border-green-500 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 focus-within:outline-[#bef264] text-sm text-gray-700">

                            <option value="" disabled selected>Select dietary preference</option>
                            <option value="None" <?= $old['dietary_preference'] === 'None' ? 'selected' : '' ?>>None
                                (General Diet)</option>
                            <option value="Vegetarian"
                                <?= $old['dietary_preference'] === 'Vegetarian' ? 'selected' : '' ?>>
                                Vegetarian</option>
                            <option value="Vegan" <?= $old['dietary_preference'] === 'Vegan' ? 'selected' : '' ?>>Vegan
                            </option>
                            <option value="Pescatarian"
                                <?= $old['dietary_preference'] === 'Pescatarian' ? 'selected' : '' ?>>
                                Pescatarian</option>
                            <option value="Lacto-Vegetarian"
                                <?= $old['dietary_preference'] === 'Lacto-Vegetarian' ? 'selected' : '' ?>>
                                Lacto-Vegetarian
                            </option>
                            <option value="Ovo-Vegetarian"
                                <?= $old['dietary_preference'] === 'Ovo-Vegetarian' ? 'selected' : '' ?>>
                                Ovo-Vegetarian</option>
                            <option value="Lacto-Ovo Vegetarian"
                                <?= $old['dietary_preference'] === 'Lacto-Ovo Vegetarian' ? 'selected' : '' ?>>Lacto-Ovo
                                Vegetarian
                            </option>
                            <option value="Gluten-Free"
                                <?= $old['dietary_preference'] === 'Gluten-Free' ? 'selected' : '' ?>>
                                Gluten-Free</option>
                            <option value="Dairy-Free"
                                <?= $old['dietary_preference'] === 'Dairy-Free' ? 'selected' : '' ?>>
                                Dairy-Free</option>
                            <option value="Nut-Free" <?= $old['dietary_preference'] === 'Nut-Free' ? 'selected' : '' ?>>
                                Nut-Free</option>
                            <option value="Low-Carb" <?= $old['dietary_preference'] === 'Low-Carb' ? 'selected' : '' ?>>
                                Low-Carb</option>
                            <option value="Keto" <?= $old['dietary_preference'] === 'Keto' ? 'selected' : '' ?>>Keto
                            </option>
                            <option value="Paleo" <?= $old['dietary_preference'] === 'Paleo' ? 'selected' : '' ?>>Paleo
                            </option>
                            <option value="Low-FODMAP"
                                <?= $old['dietary_preference'] === 'Low-FODMAP' ? 'selected' : '' ?>>
                                Low-FODMAP</option>
                            <option value="Halal" <?= $old['dietary_preference'] === 'Halal' ? 'selected' : '' ?>>Halal
                            </option>
                            <option value="Kosher" <?= $old['dietary_preference'] === 'Kosher' ? 'selected' : '' ?>>
                                Kosher
                            </option>
                            <option value="Diabetic-Friendly"
                                <?= $old['dietary_preference'] === 'Diabetic-Friendly' ? 'selected' : '' ?>>
                                Diabetic-Friendly
                            </option>
                            <option value="Heart-Healthy"
                                <?= $old['dietary_preference'] === 'Heart-Healthy' ? 'selected' : '' ?>>Heart-Healthy
                            </option>
                            <option value="Whole30" <?= $old['dietary_preference'] === 'Whole30' ? 'selected' : '' ?>>
                                Whole30
                            </option>
                            <option value="Raw Food" <?= $old['dietary_preference'] === 'Raw Food' ? 'selected' : '' ?>>
                                Raw
                                Food</option>
                        </select>

                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cooking Difficulty Level</label>
                        <?php if (!empty($errors['difficulty'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['difficulty']) ?>
                        </div>
                        <?php endif; ?>
                        <select name="difficulty"
                            class="block w-full p-2 border border-green-500 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 focus-within:outline-[#bef264] text-sm text-gray-700">
                            <option value="" disabled selected>Select Cooking Difficulty Level</option>
                            <option value="Easy" <?= $old['difficulty'] === 'Easy' ? 'selected' : '' ?>>Easy
                            </option>
                            <option value="Medium" <?= $old['difficulty'] === 'Medium' ? 'selected' : '' ?>>Medium
                            </option>
                            <option value="Hard" <?= $old['difficulty'] === 'Hard' ? 'selected' : '' ?>>Hard</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="cooking_time" class="block text-sm font-medium text-gray-700">Cooking Time</label>
                        <?php if (!empty($errors['cooking_time'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['cooking_time']) ?>
                        </div>
                        <?php endif; ?>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="number" name="cooking_time" id="cooking_time" min="1"
                                class="block w-full p-2 border border-green-500 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 focus-within:outline-[#bef264] text-sm text-gray-700"
                                value="<?= isset($old['cooking_time']) ? htmlspecialchars($old['cooking_time']) : (isset($recipe['cooking_time']) ? htmlspecialchars($recipe['cooking_time']) : '') ?>"
                                placeholder="e.g. 30">
                            <span
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                minutes
                            </span>
                        </div>
                    </div>
                    <button type="submit"
                        class=" bg-green-600 hover:bg-green-100 shadow-md hover:text-green-600 flex justify-center text-white font-semibold py-2 px-4 rounded-md  transition duration-300 ">Edit
                        Recipe</button>
                </div>
            </form>
        </div>

    </section>
    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

    <script>
    document.getElementById('recipe_photo').addEventListener('change', function(e) {
        const preview = document.getElementById('recipePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    document.getElementById('instruction_photo').addEventListener('change', function(e) {
        const preview = document.getElementById('instructionPreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    function addIngredient() {
        let container = document.getElementById('ingredientsContainer');
        let newField = document.createElement('div');
        newField.className = "flex space-x-2 mb-2";
        newField.innerHTML = `
    <input type="text" name="ingredient_name[]" placeholder="Ingredient" class="flex items-center rounded-md bg-white outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-1/3 p-2">
    <input type="text" name="quantity[]" placeholder="Quantity" class="flex items-center rounded-md bg-white outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-1/3 p-2">
    <input type="text" name="unit[]" placeholder="Unit" class="flex items-center rounded-md bg-white outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-1/3 p-2">
    <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 rounded-md hover:bg-red-100 transition-all duration-300 shadow-md hover:text-red-600">-</button>
  `;
        container.appendChild(newField);
    }

    function addInstruction() {
        let container = document.getElementById('instructionsContainer');
        let newField = document.createElement('div');
        newField.className = "flex space-x-2 mb-2";
        newField.innerHTML = `
    <input type="number" name="step_number[]" placeholder="Step #" class="flex items-center rounded-md bg-white p-2 w-1/3 outline-1 outline-[#16a34a]">
    <textarea name="step_text[]" placeholder="Instruction" class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"></textarea>
    <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 rounded-md hover:bg-red-100 transition-all duration-300 shadow-md hover:text-red-500">-</button>
  `;
        container.appendChild(newField);
    }
    </script>
</body>

</html>
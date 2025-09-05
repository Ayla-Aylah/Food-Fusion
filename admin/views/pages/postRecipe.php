<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}


$errors = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Recipe</title>
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

        <div class=" min-h-screen flex items-center justify-center flex-col  px-4 sm:px-6 lg:px-8 ">
            <div class="container mx-auto mt-10 p-4">
                <h1 class="text-center text-2xl  text-[#111827]  font-bold mb-4">Post New Recipe</h1>
                <?php if (!empty($errors['recipePost'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['recipePost']) ?>
                </div>
                <?php endif;?>
            </div>

            <form action="/foodfusion/admin/postRecipe" method="POST" enctype="multipart/form-data" class=" bg-white p-6 w-full grid
                grid-cols-1 md:grid-cols-2">
                <div class="flex flex-col items-center justify-start mr-5  ">
                    <div class=" mb-4 rounded-2xl shadow-md">
                        <!-- Current profile image -->
                        <?php if (!empty($recipe['recipe_photo'])): ?>
                        <img class="w-100 h-100 object-cover rounded-2xl " id="recipePreview"
                            src="/foodfusion/public/<?= $recipe['recipe_photo']; ?>" alt="Recipe Photo"
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
                            class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['recipe_title'])?htmlspecialchars($old['recipe_title']?? ''):''?>">
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
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "><?= !empty($errors['recipe_description']) ? '' : htmlspecialchars($old['recipe_description'] ?? '') ?></textarea>
                    </div>


                    <!-- Ingredients Section -->
                    <?php
                        $ingredientNames = $old['ingredient_name'] ?? [''];
                        $quantities = $old['quantity'] ?? [''];
                        $units = $old['unit'] ?? [''];
                    ?>

                    <div id="ingredientsContainer" class="mb-4">
                        <label class="block text-sm text-[#111827] font-medium">Ingredients</label>
                        <?php if (!empty($errors['ingredients'])): ?>
                        <div class="text-red-500 text-sm py-1">
                            <?= htmlspecialchars($errors['ingredients']) ?>
                        </div>
                        <?php endif; ?>

                        <?php foreach ($ingredientNames as $index => $ingredient): ?>
                        <div class="flex space-x-2 mb-2">
                            <input type="text" name="ingredient_name[]" value="<?= htmlspecialchars($ingredient) ?>"
                                placeholder="Ingredient"
                                class="flex items-center rounded-md bg-white pl-3 p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="quantity[]"
                                value="<?= htmlspecialchars($quantities[$index] ?? '') ?>" placeholder="Quantity"
                                class="flex items-center rounded-md bg-white pl-3 p-2 w-full outline-1 outline-[#16a34a]">
                            <input type="text" name="unit[]" value="<?= htmlspecialchars($units[$index] ?? '') ?>"
                                placeholder="Unit"
                                class="flex items-center rounded-md bg-white pl-3 p-2 w-full outline-1 outline-[#16a34a]">
                            <button type="button" onclick="addIngredient()"
                                class="bg-green-500 text-white px-3 rounded-md hover:bg-green-100">+</button>
                        </div>
                        <?php endforeach; ?>
                    </div>


                    <?php
                        $stepNumbers = $old['step_number'] ?? [''];
                        $stepTexts = $old['step_text'] ?? [''];
                    ?>

                    <div id="instructionsContainer" class="mb-4">
                        <label class="block text-sm text-[#111827] font-medium">Instructions</label>
                        <?php if (!empty($errors['instructions'])): ?>
                        <div class="text-red-500 text-sm py-1">
                            <?= htmlspecialchars($errors['instructions']) ?>
                        </div>
                        <?php endif; ?>

                        <?php foreach ($stepNumbers as $index => $stepNum): ?>
                        <div class="flex space-x-2 mb-2">
                            <input type="number" name="step_number[]" value="<?= htmlspecialchars($stepNum) ?>"
                                placeholder="Step #"
                                class="flex items-center rounded-md bg-white p-2 w-1/3 outline-1 outline-[#16a34a]">
                            <textarea name="step_text[]" placeholder="Instruction"
                                class="resize-none flex items-center rounded-md bg-white p-2 w-full outline-1 outline-[#16a34a]"><?= htmlspecialchars($stepTexts[$index] ?? '') ?></textarea>
                            <button type="button" onclick="addInstruction()"
                                class="bg-green-500 text-white px-3 rounded-md hover:bg-green-100">+</button>
                        </div>
                        <?php endforeach; ?>
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
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['recipe_tips'])?htmlspecialchars($old['recipe_tips']?? ''):''?>"><?= !empty($errors['recipe_tips']) ? '' : htmlspecialchars($old['recipe_tips'] ?? '') ?></textarea>
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
                            value="<?= empty($errors['nutrition'])?htmlspecialchars($old['nutrition']?? ''):''?>"><?= !empty($errors['nutrition']) ? '' : htmlspecialchars($old['nutrition'] ?? '') ?>
                        </textarea>
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

                            <option value="Global">Global</option>
                            <optgroup label="Asian Cuisines">
                                <option value="Asian">Asian</option>
                                <option value="Afghan">Afghan</option>
                                <option value=" Bangladeshi">Bangladeshi</option>
                                <option value="Burmese">Burmese</option>
                                <option value="Cambodian">Cambodian</option>
                                <option value="Chinese">Chinese</option>
                                <option value="Filipino">Filipino</option>
                                <option value="Indian">Indian</option>
                                <option value="Indonesian">Indonesian</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Korean">Korean</option>
                                <option value="Laotian">Laotian</option>
                                <option value="Malaysian">Malaysian</option>
                                <option value="Mongolian">Mongolian</option>
                                <option value="Nepalese">Nepalese</option>
                                <option value="Pakistani">Pakistani</option>
                                <option value="Sri Lankan">Sri Lankan</option>
                                <option value="Taiwanese">Taiwanese</option>
                                <option value="Thai">Thai</option>
                                <option value="Vietnamese">Vietnamese</option>
                            </optgroup>

                            <optgroup label="European Cuisines">
                                <option value="European">European</option>
                                <option value="British">British</option>
                                <option value="Bulgarian">Bulgarian</option>
                                <option value="Croatian">Croatian</option>
                                <option value="Czech">Czech</option>
                                <option value="Dutch">Dutch</option>
                                <option value="Finnish">Finnish</option>
                                <option value="French">French</option>
                                <option value="German">German</option>
                                <option value="Greek">Greek</option>
                                <option value="Hungarian">Hungarian</option>
                                <option value="Irish">Irish</option>
                                <option value="Italian">Italian</option>
                                <option value="Polish">Polish</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Romanian">Romanian</option>
                                <option value="Russian">Russian</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Swedish">Swedish</option>
                                <option value="Swiss">Swiss</option>
                                <option value="Turkish">Turkish</option>
                                <option value="Ukrainian">Ukrainian</option>
                            </optgroup>

                            <optgroup label="Middle Eastern & African Cuisines">
                                <option value="Africa">African</option>
                                <option value="Middle Eastern">Middle Eastern</option>
                                <option value="Algerian">Algerian</option>
                                <option value="Egyptian">Egyptian</option>
                                <option value="Ethiopian">Ethiopian</option>
                                <option value="Iranian">Iranian</option>
                                <option value="Iraqi">Iraqi</option>
                                <option value="Israeli">Israeli</option>
                                <option value="Jordanian">Jordanian</option>
                                <option value="Lebanese">Lebanese</option>
                                <option value="Libyan">Libyan</option>
                                <option value="Moroccan">Moroccan</option>
                                <option value="Palestinian">Palestinian</option>
                                <option value="Saudi Arabian">Saudi Arabian</option>
                                <option value="Somali">Somali</option>
                                <option value="Sudanese">Sudanese</option>
                                <option value="Syrian">Syrian</option>
                                <option value="Tunisian">Tunisian</option>
                                <option value="Yemeni">Yemeni</option>
                                <option value="South African">South African</option>
                                <option value="Nigerian">Nigerian</option>
                                <option value="Ghanaian">Ghanaian</option>
                            </optgroup>

                            <optgroup label="American & Latin Cuisines">
                                <option value="Latin">Latin</option>
                                <option value="American">American</option>
                                <option value="Argentinian">Argentinian</option>
                                <option value="Brazilian">Brazilian</option>
                                <option value="Caribbean">Caribbean</option>
                                <option value="Chilean">Chilean</option>
                                <option value="Colombian">Colombian</option>
                                <option value="Cuban">Cuban</option>
                                <option value="Dominican">Dominican</option>
                                <option value="Haitian">Haitian</option>
                                <option value="Jamaican">Jamaican</option>
                                <option value="Mexican">Mexican</option>
                                <option value="Peruvian">Peruvian</option>
                                <option value="Puerto Rican">Puerto Rican</option>
                                <option value="Uruguayan">Uruguayan</option>
                                <option value="Venezuelan">Venezuelan</option>
                            </optgroup>

                            <optgroup label="Oceanian Cuisines">
                                <option value="Oceanian">Oceanian</option>
                                <option value="Australian">Australian</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Polynesian">Polynesian</option>
                                <option value="Hawaiian">Hawaiian</option>
                                <option value="Fijian">Fijian</option>
                                <option value="Samoan">Samoan</option>
                            </optgroup>

                        </select>

                    </div>

                    <div class="mb-5">
                        <label for="diet" class="block text-sm font-medium text-gray-700 mb-1">Dietary
                            Preference</label>
                        <?php if (!empty($errors['diet'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['diet']) ?>
                        </div>
                        <?php endif; ?>
                        <select id="diet" name="diet"
                            class="block w-full p-2 border border-green-500 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 focus-within:outline-[#bef264] text-sm text-gray-700">

                            <option value="" disabled selected>Select dietary preference</option>
                            <option value="None">None (General Diet)</option>
                            <option value="Vegetarian">Vegetarian</option>
                            <option value="Vegan">Vegan</option>
                            <option value="Pescatarian">Pescatarian</option>
                            <option value="Lacto-Vegetarian">Lacto-Vegetarian</option>
                            <option value="Ovo-Vegetarian">Ovo-Vegetarian</option>
                            <option value="Lacto-Ovo Vegetarian">Lacto-Ovo Vegetarian</option>
                            <option value="Gluten-Free">Gluten-Free</option>
                            <option value="Dairy-Free">Dairy-Free</option>
                            <option value="Nut-Free">Nut-Free</option>
                            <option value="Low-Carb">Low-Carb</option>
                            <option value="Keto">Keto</option>
                            <option value="Paleo">Paleo</option>
                            <option value="Low-FODMAP">Low-FODMAP</option>
                            <option value="Halal">Halal</option>
                            <option value="Kosher">Kosher</option>
                            <option value="Diabetic-Friendly">Diabetic-Friendly</option>
                            <option value="Heart-Healthy">Heart-Healthy</option>
                            <option value="Whole30">Whole30</option>
                            <option value="Raw Food">Raw Food</option>
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
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
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
                                placeholder="e.g. 30">
                            <span
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                minutes
                            </span>
                        </div>
                    </div>
                    <button type="submit" class=" bg-green-600 hover:bg-green-100 shadow-md hover:text-green-600 flex justify-center text-white 
                        font-semibold py-2 px-4 rounded-md  transition duration-300 ">Post
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
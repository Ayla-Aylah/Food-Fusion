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

unset($_SESSION['error'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Cooking Tutorial | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php 
     include_once __DIR__ . '/../../views/partials/header.php'; ?>
    <form action="/foodfusion/admin/postCookingTutorial" method="POST" enctype="multipart/form-data"
        class="space-y-6 m-10">

        <div>
            <label class="block font-medium">Title</label>
            <?php if (!empty($errors['title'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['title']) ?>
            </div>
            <?php endif; ?>
            <input type="text" name="title" class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400
                focus:outline-none focus:ring-2 focus:ring-green-500"
                value="<?= empty($errors['title'])?htmlspecialchars($old['title']?? ''):''?>">
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <?php if (!empty($errors['description'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['description']) ?>
            </div>
            <?php endif; ?>
            <textarea name="description" rows="4"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 
                focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"><?= !empty($errors['description']) ? '' : htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block font-medium">Upload Video (MP4 only)</label>
            <?php if (!empty($errors['video_file'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['video_file']) ?>
            </div>
            <?php endif; ?>
            <input type="file" name="video_file" class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 
                focus:outline-none focus:ring-2 focus:ring-green-500 " accept="video/mp4">
        </div>

        <div class="mb-5">
            <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine
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
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Submit Tutorial
        </button>
    </form>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
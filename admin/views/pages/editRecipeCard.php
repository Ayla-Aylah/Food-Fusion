<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
use AdminModel\AdminResource;
$model = new AdminResource();
$id = $_GET['id'];
$card = $model->getRecipeCardById($id);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe Card | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <form action="/foodfusion/admin/updateRecipeCard" method="POST" enctype="multipart/form-data"
        class="space-y-4 m-10">

        <input type="hidden" name="id" value="<?= $card['id'] ?>">
        <h1 class="text-2xl font-bold mb-4">Edit Recipe Card</h1>

        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Description</label>
        <textarea name="description"
            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "><?= htmlspecialchars($card['description']) ?></textarea>

        <label>Upload Recipe Card File (PDF/Image) (leave empty to keep current)</label>
        <input type="file" name="file"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Upload Cover Photo (leave empty to keep current)</label>
        <input type="file" name="cover_photo"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Cuisine</label>
        <input type="text" name="cuisine" value="<?= htmlspecialchars($card['cuisine']) ?>"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Diet</label>
        <input type="text" name="diet" value="<?= htmlspecialchars($card['diet']) ?>"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Difficulty</label>
        <input type="text" name="difficulty" value="<?= htmlspecialchars($card['difficulty']) ?>"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <label>Cooking Time</label>
        <input type="text" name="cooking_time" value="<?= htmlspecialchars($card['cooking_time']) ?>"
            class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update Recipe Card</button>
    </form>
    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>
</body>

</html>
<?php
use AdminModel\AdminResource;
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}

$model = new AdminResource();
$cards = $model->getAllRecipeCards();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Cards | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>


<body class="bg-gray-50 text-gray-800 font-[poppins]">
    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <section class="px-3 py-14 max-w-7xl mx-auto">

        <div class="flex items-center justify-between ">
            <h1 class="text-3xl font-bold mb-6 text-green-600">Recipe Cards</h1>
            <a href="/foodfusion/admin/postRecipeCard"
                class=" px-3 py-2 mr-10 transition-all duration-300 shadow-md text-white rounded-lg bg-green-600 hover:bg-green-100 hover:text-green-600">+
                Post
                new recipe</a>
        </div>
        <div class="container mb-5 mx-auto px-8 z-10 overflow-x-auto
        [&::-webkit-scrollbar]:h-2
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <table class="w-full border-collapse border">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="border px-3 py-2">Title</th>
                        <th class="border px-3 py-2">Cover</th>
                        <th class="border px-3 py-2">Cuisine</th>
                        <th class="border px-3 py-2">Difficulty</th>
                        <th class="border px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cards as $card): ?>
                    <tr>
                        <td class="border px-3 py-2"><?= htmlspecialchars($card['title']) ?></td>
                        <td class="border px-3 py-2">
                            <img src="/foodfusion/public/<?= htmlspecialchars($card['cover_photo']) ?>"
                                class="w-20 h-20 object-cover rounded-xl">
                        </td>
                        <td class="border px-3 py-2"><?= htmlspecialchars($card['cuisine']) ?></td>
                        <td class="border px-3 py-2"><?= htmlspecialchars($card['difficulty']) ?></td>
                        <td class="border px-3 py-2 ">
                            <a href="/foodfusion/admin/editRecipeCard?id=<?= $card['id'] ?>"
                                class="text-blue-600 ">Edit</a>
                            |
                            <a href="/foodfusion/admin/deleteRecipeCard?id=<?= $card['id'] ?>" class="text-red-600"
                                onclick="return confirm('Delete this recipe card?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include_once __DIR__.'/../partials/footer.php'; ?>

</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cooking Tutorials | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between ">
            <h1 class="text-3xl font-bold mb-6 text-green-600">Cooking Tutorials</h1>
            <a href="/foodfusion/admin/postCookingTutorial"
                class=" px-3 py-2 mr-10 transition-all duration-300 shadow-md text-white rounded-lg bg-green-600 hover:bg-green-100 hover:text-green-600">+
                Post
                new Cooking Tutorial</a>
        </div>
        <div class="container mb-5 mx-auto px-8 z-10 overflow-x-auto
        [&::-webkit-scrollbar]:h-2
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <table class="w-full table-auto border border-gray-300 bg-white shadow rounded-xl">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Cuisine</th>
                        <th class="px-4 py-3">Diet</th>
                        <th class="px-4 py-3">Difficulty</th>
                        <th class="px-4 py-3">Cooking Time</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tutorials)): ?>
                    <?php foreach ($tutorials as $tut): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['id']) ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['title']) ?></td>

                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['cuisine']) ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['diet']) ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['difficulty']) ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($tut['created_at']) ?></td>
                        <td class="px-3 py-2 flex gap-2 justify-center items-center">
                            <a href="/foodfusion/admin/editTutorial?id=<?= $tut['id'] ?>"
                                class=" text-blue-400 px-3 py-1 ">Edit</a>
                            <a href="/foodfusion/admin/deleteTutorial?id=<?= $tut['id'] ?>"
                                onclick="return confirm('Are you sure to delete this tutorial?');"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center p-4">No tutorial videos found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>
</body>

</html>
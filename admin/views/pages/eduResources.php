<?php
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
    <title>Educational Resources | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="m-10">
        <div class="flex items-center justify-between ">
            <h1 class="text-3xl font-bold mb-6 text-green-600">Educational Resources</h1>
            <a href="/foodfusion/admin/postEduResources"
                class=" px-3 py-2 mr-10 transition-all duration-300 shadow-md text-white rounded-lg bg-green-600 hover:bg-green-100 hover:text-green-600">+
                Post
                new Resource</a>
        </div>

        <div class="container mb-5 mx-auto px-8 z-10 overflow-x-auto
        [&::-webkit-scrollbar]:h-2
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">

            <?php if (!empty($resources)) : ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Type</th>
                        <th class="p-3 border">Created At</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resources as $index => $res): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 border"><?= $index + 1 ?></td>

                        <td class="p-3 border"><?= htmlspecialchars($res['title']) ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($res['type'] ?? '-') ?></td>
                        <td class="p-3 border"><?= date('M j, Y', strtotime($res['created_at'])) ?></td>
                        <td class="p-3 border text-center ">
                            <a href="/foodfusion/admin/editEdu?id=<?= $res['id'] ?>"
                                class="text-blue-600 hover:underline mb-3 md:mb-0">Edit</a>
                            |
                            <a href="/foodfusion/admin/deleteEdu?id=<?= $res['id'] ?>"
                                class="hover:text-red-600 hover:underline hover:bg-red-100 shadow-md bg-red-500 text-white transition-all duration-300 p-2 rounded-md"
                                onclick="return confirm('Delete this resource?')">Delete</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-gray-600">No recipes found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
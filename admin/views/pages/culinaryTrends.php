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
    <title>Culinary Trends| Food Fusion</title>
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
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold mb-6 text-green-600">🌱 Culinary Trends</h1>
            <a href="/foodfusion/admin/postCulinaryTrends"
                class="px-4 py-2 text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">+ Post New
                Trend</a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
            <?php if (!empty($trends)) : ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Image</th>
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Description</th>
                        <th class="p-3 border">Created At</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>


                <tbody>
                    <?php foreach ($trends as $index => $trend): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 border"><?= $index + 1 ?></td>
                        <td class="p-3 border text-center">
                            <?php if (!empty($trend['trend_image'])): ?>
                            <img src="/foodfusion/public/<?= htmlspecialchars($trend['trend_image']) ?>"
                                class="w-20 h-20 object-cover rounded-xl mx-auto">
                            <?php else: ?>
                            <div
                                class="w-20 h-20 bg-gray-200 flex items-center justify-center text-gray-500 rounded-xl">
                                ❌</div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3 border font-semibold"><?= htmlspecialchars($trend['trend_title']) ?></td>
                        <td class="p-3 border text-gray-600">
                            <?= htmlspecialchars(mb_strimwidth($trend['trend_description'], 0, 60, '...')) ?></td>
                        <td class="p-3 border"><?= date('M j, Y', strtotime($trend['created_at'])) ?></td>
                        <td class="px-4 py-3 border space-x-2">
                            <a href="/foodfusion/admin/editCulinaryTrend?id=<?= $trend['trend_id'] ?>"
                                class="text-green-600 hover:underline">Edit</a>

                            <form action="deleteCulinaryTrend" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $trend['trend_id'] ?>">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="btn btn-danger bg-red-500 px-3 py-2 text-white rounded-md hover:bg-red-100 hover:text-red-500 shadow-md  transition duration-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-gray-600 p-4">No culinary trends posted yet.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
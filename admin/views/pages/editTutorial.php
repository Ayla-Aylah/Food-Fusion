<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
$errors = $_SESSION['error'] ?? [];
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cooking Tutorial | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>


<body class="bg-gray-50 text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow space-y-6 mt-8">
        <h2 class="text-2xl font-bold">Edit Tutorial Video</h2>

        <form action="/foodfusion/admin/updateTutorial" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($tutorial['id']) ?>">

            <!-- Title -->
            <div>
                <label class="block font-semibold">Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($tutorial['title']) ?>"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Description -->
            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($tutorial['description']) ?></textarea>
            </div>

            <!-- Existing Video Preview -->
            <?php if (!empty($tutorial['video_link'])): ?>
            <div>
                <label class="block font-semibold mb-1">Current Video</label>
                <video controls class="w-72 h-44 rounded-xl">
                    <source src="/foodfusion/public/<?= htmlspecialchars($tutorial['video_link']) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <?php endif; ?>

            <!-- Upload New Video -->
            <div>
                <label class="block font-semibold">Upload New Video (leave empty to keep current)</label>
                <input type="file" name="video_file"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500"
                    accept="video/mp4">
            </div>

            <!-- Cuisine -->
            <div>
                <label class="block font-semibold">Cuisine</label>
                <input type="text" name="cuisine" value="<?= htmlspecialchars($tutorial['cuisine']) ?>"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Diet -->
            <div>
                <label class="block font-semibold">Diet</label>
                <input type="text" name="diet" value="<?= htmlspecialchars($tutorial['diet']) ?>"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Difficulty -->
            <div>
                <label class="block font-semibold">Difficulty</label>
                <input type="text" name="difficulty" value="<?= htmlspecialchars($tutorial['difficulty']) ?>"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Cooking Time -->
            <div>
                <label class="block font-semibold">Cooking Time (minutes)</label>
                <input type="number" name="cooking_time" value="<?= htmlspecialchars($tutorial['cooking_time']) ?>"
                    class="w-full border border-green-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700 transition">Update
                    Tutorial</button>
            </div>
        </form>
    </div>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <title>Edit Infographic | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="font-[poppins] text-gray-800">

    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">

        <h2 class="text-2xl font-semibold mb-4">Edit Infographic</h2>

        <form action="/foodfusion/admin/editInfo?id=<?= $info['id'] ?>" method="POST" enctype="multipart/form-data"
            class="space-y-4">

            <label class="block">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($info['title']) ?>"
                class="w-full rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            <?php if (!empty($errors['title'])): ?>
            <p class="text-red-500 text-sm"><?= htmlspecialchars($errors['title']) ?></p>
            <?php endif; ?>

            <label class="block">Description</label>
            <textarea name="description" rows="4"
                class="w-full resize-none rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($info['description']) ?></textarea>
            <?php if (!empty($errors['description'])): ?>
            <p class="text-red-500 text-sm"><?= htmlspecialchars($errors['description']) ?></p>
            <?php endif; ?>

            <div>
                <label class="block">Upload New Image (leave empty to keep current)</label>
                <input type="file" name="image"
                    class="w-full rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
                <?php if (!empty($errors['image'])): ?>
                <p class="text-red-500 text-sm"><?= htmlspecialchars($errors['image']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">Update
                Infographic</button>
        </form>

    </div>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
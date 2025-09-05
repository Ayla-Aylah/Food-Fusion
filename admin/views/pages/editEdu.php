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
    <title>Edit Resource | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <form action="/foodfusion/admin/updateEduResource/<?= $resource['id'] ?>" method="POST"
        enctype="multipart/form-data" class="space-y-4 p-5 m-10 bg-white rounded shadow-md max-w-xl mx-auto">

        <h2 class="text-xl font-semibold">Edit Educational Resource</h2>

        <label class="block">Title</label>
        <?php if (!empty($errors['title'])): ?>
        <div class="text-red-500 text-sm py-1"><?= htmlspecialchars($errors['title']) ?></div>
        <?php endif; ?>
        <input type="text" name="title" value="<?= htmlspecialchars($resource['title']) ?>"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">

        <label class="block">Description</label>
        <?php if (!empty($errors['description'])): ?>
        <div class="text-red-500 text-sm py-1"><?= htmlspecialchars($errors['description']) ?></div>
        <?php endif; ?>
        <textarea name="description" rows="4"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($resource['description']) ?></textarea>

        <label class="block">Resource Type</label>
        <?php if (!empty($errors['type'])): ?>
        <div class="text-red-500 text-sm py-1"><?= htmlspecialchars($errors['type']) ?></div>
        <?php endif; ?>
        <select name="type" id="typeSelector"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            <option value="" disabled>Select type</option>
            <option value="download" <?= $resource['type'] === 'download' ? 'selected' : '' ?>>Downloadable (PDF/DOC)
            </option>
            <option value="infographic" <?= $resource['type'] === 'infographic' ? 'selected' : '' ?>>Infographic (Image)
            </option>
            <option value="video" <?= $resource['type'] === 'video' ? 'selected' : '' ?>>Video (Upload/YouTube)</option>
        </select>

        <div id="fileUploadSection" class="<?= $resource['type'] === 'infographic' ? '' : 'hidden' ?>">
            <label class="block">Upload Infographic (leave empty to keep current)</label>
            <input type="file" name="file"
                class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
        </div>

        <div id="coverUploadSection" class="<?= $resource['type'] === 'download' ? '' : 'hidden' ?>">
            <label class="block">Upload File (leave empty to keep current)</label>
            <input type="file" name="file"
                class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            <label class="block">Upload Cover Image</label>
            <input type="file" name="cover_image"
                class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
        </div>

        <div id="videoURLSection" class="<?= $resource['type'] === 'video' ? '' : 'hidden' ?>">
            <label class="block">Upload Video (leave empty to keep current)</label>
            <input type="file" name="video_file" accept="video/mp4"
                class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Update
            Resource</button>
    </form>

    <script>
    document.getElementById('typeSelector').addEventListener('change', function() {
        const type = this.value;

        // Reset inputs
        document.querySelector('input[name="file"]').value = '';
        document.querySelector('input[name="video_file"]').value = '';

        document.getElementById('fileUploadSection').classList.add('hidden');
        document.getElementById('videoURLSection').classList.add('hidden');
        document.getElementById('coverUploadSection').classList.add('hidden');

        if (type === 'infographic') {
            document.getElementById('fileUploadSection').classList.remove('hidden');
        } else if (type === 'download') {
            document.getElementById('coverUploadSection').classList.remove('hidden');
        } else if (type === 'video') {
            document.getElementById('videoURLSection').classList.remove('hidden');
        }
    });
    </script>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>
</body>

</html>
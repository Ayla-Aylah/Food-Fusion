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
    <title>Post Hacks | Food Fusion</title>
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
    <form action="/foodfusion/admin/postHacks" method="POST" enctype="multipart/form-data" class="space-y-6 m-10">

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
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"><?=  !empty($errors['description']) ? '' : htmlspecialchars($old['description'] ?? '')  ?></textarea>
        </div>

        <div>
            <label class="block font-medium">Upload Video (MP4 only)</label>
            <?php if (!empty($errors['video_file'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['video_file']) ?>
            </div>
            <?php endif; ?>
            <input type="file" name="video_file"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 "
                accept="video/mp4">
        </div>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Submit Hack
        </button>
    </form>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
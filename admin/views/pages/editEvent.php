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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Cooking Event | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body class="bg-gray-50 text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>
    <?php if (!empty($_SESSION['error'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
    <?php endif; ?>
    <form action="/foodfusion/admin/editEventProcess" method="POST" enctype="multipart/form-data"
        class="space-y-5 bg-white p-8 rounded-xl shadow">
        <h1 class="text-3xl font-bold mb-6 text-green-600">✏️ Edit Event</h1>
        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
        <div>
            <label class="block font-medium mb-1">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none 
                focus:ring-2 focus:ring-green-500">
        </div>
        <div>
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="4"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none 
                focus:ring-2 focus:ring-green-500 resize-none"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Date & Time</label>
            <input type="datetime-local" name="event_date"
                value="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-medium mb-1">Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-medium mb-1">Registration Link (Optional)</label>
            <input type="text" name="registration_link" value="<?= htmlspecialchars($event['registration_link']) ?>"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-medium mb-1">Change Event Image (Optional)</label>
            <input type="file" name="event_image"
                class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            <?php if (!empty($event['event_image'])): ?>
            <img src="/foodfusion/public<?= $event['event_image'] ?>" class="w-32 mt-3 rounded shadow">
            <?php endif; ?>
        </div>

        <button type="submit" class="px-6 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">💾 Update
            Event</button>
    </form> <?php include_once __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
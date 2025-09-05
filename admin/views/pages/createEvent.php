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
    <title>Event List | FoodFusion</title>
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

    <section class="max-w-4xl mx-auto p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-8">📅 Create New Cooking Event</h1>
        <form action="/foodfusion/admin/createEvent" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                <?php if (!empty($errors['title'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['title']; unset($errors['title']); ?>
                </div>
                <?php endif; ?>
                <input type="text" name="title"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Description</label>
                <?php if (!empty($errors['description'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['description']; unset($errors['description']); ?>
                </div>
                <?php endif; ?>
                <textarea name="description" rows="4"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Image</label>
                <?php if (!empty($errors['event_image'])): ?>
                <div class="mb-4 py-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['event_image']; unset($errors['event_image']); ?>
                </div>
                <?php endif; ?>
                <input type="file" name="event_image"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Date & Time</label>
                <?php if (!empty($errors['event_date'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['event_date']; unset($errors['event_date']); ?>
                </div>
                <?php endif; ?>
                <input type="datetime-local" name="event_date"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <?php if (!empty($errors['location'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['location']; unset($errors['location']); ?>
                </div>
                <?php endif; ?>
                <input type="text" name="location"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Link</label>
                <?php if (!empty($errors['registration_link'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $errors['registration_link']; unset($errors['registration_link']); ?>
                </div>
                <?php endif; ?>
                <input type="text" name="registration_link"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                + Create Event
            </button>

        </form>
    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
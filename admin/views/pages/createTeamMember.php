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
    <title>Post Cooking Tutorial | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <form action="/foodfusion/admin/createTeamMember" method="POST" enctype="multipart/form-data"
        class="space-y-4 p-5 bg-white rounded shadow-md max-w-xl mx-auto mt-5">
        <h1 class="text-3xl font-bold mb-6 text-green-600">Add New Team Member</h1>

        <?php if (!empty($errors['name'])): ?>
        <div class=" text-red-500 text-sm py-1 ">
            <?= htmlspecialchars($errors['name']) ?>
        </div>
        <?php endif; ?>
        <input type="text" name="name" placeholder="Name"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">

        <?php if (!empty($errors['position'])): ?>
        <div class=" text-red-500 text-sm py-1 ">
            <?= htmlspecialchars($errors['position']) ?>
        </div>
        <?php endif; ?>
        <input type="text" name="position" placeholder="Position"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">

        <?php if (!empty($errors['photo'])): ?>
        <div class=" text-red-500 text-sm py-1 ">
            <?= htmlspecialchars($errors['photo']) ?>
        </div>
        <?php endif; ?>
        <input type="file" name="photo"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">

        <?php if (!empty($errors['email'])): ?>
        <div class=" text-red-500 text-sm py-1 ">
            <?= htmlspecialchars($errors['email']) ?>
        </div>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Email"
            class="w-full rounded-xl border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">

        <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
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
    <title>Edit Team Member | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="max-w-3xl mx-auto p-8 mt-10 bg-white rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-green-700 mb-8">✏️ Edit Team Member</h2>

        <form action="/foodfusion/admin/editTeamMember" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?= $member['id'] ?>">
            <input type="hidden" name="current_photo" value="<?= htmlspecialchars($member['photo']) ?>">

            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($member['name']) ?>"
                    class="w-full rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block font-medium mb-1">Position</label>
                <input type="text" name="position" value="<?= htmlspecialchars($member['position']) ?>"
                    class="w-full rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block font-medium mb-1">email</label>
                <input type="text" name="position" value="<?= htmlspecialchars($member['email']) ?>"
                    class="w-full rounded-lg border border-green-300 px-4 py-3 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block font-medium mb-1">Profile Photo</label>
                <?php if ($member['photo']): ?>
                <img src="/foodfusion/public/<?= htmlspecialchars($member['photo']) ?>" alt=""
                    class="w-32 h-32 object-cover rounded-full mb-3">
                <?php endif; ?>
                <input type="file" name="photo"
                    class="w-full rounded-lg border border-green-300 px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>


            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-lg transition duration-300">💾
                Save Changes</button>
        </form>

    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
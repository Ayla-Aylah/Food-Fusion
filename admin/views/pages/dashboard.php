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
    <title>Admin Dashboard | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen text-gray-800 font-[Poppins] ">
    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <div class="p-6 md:p-10 font-[poppins]">
        <h1 class="text-3xl font-bold text-green-600 mb-6">Welcome to the Admin Dashboard</h1>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-sm text-gray-600 uppercase">Total Users</h2>
                <p class="text-3xl font-bold text-green-600 mt-2"><?= $userCount ?? 0 ?></p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-sm text-gray-600 uppercase">Total Recipes</h2>
                <p class="text-3xl font-bold text-green-600 mt-2"><?= $recipeCount ?? 0 ?></p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-sm text-gray-600 uppercase">Contact Messages</h2>
                <p class="text-3xl font-bold text-green-600 mt-2"><?= $messageCount ?? 0 ?></p>
            </div>
        </div>

        <!-- Latest Events -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upcoming Events</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead class="bg-green-600 text-white text-left">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcomingEvents as $event): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?= htmlspecialchars($event['title']) ?></td>
                            <td class="px-4 py-2"><?= date('F j, Y', strtotime($event['event_date'])) ?></td>
                            <td class="px-4 py-2">
                                <span class="text-green-600 font-medium">Scheduled</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Recipes -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Recent Recipes</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead class="bg-green-600 text-white text-left">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Posted By</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Featured</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentRecipes as $recipe): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?= htmlspecialchars($recipe['title']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($recipe['postedby']) ?></td>
                            <td class="px-4 py-2"><?= date('F j, Y', strtotime($recipe['created_at'])) ?></td>
                            <td class="px-4 py-2">
                                <?= $recipe['is_featured'] ? '✅' : '—' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include_once __DIR__.'/../partials/footer.php'; ?>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
</body>

</html>
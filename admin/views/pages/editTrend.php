<?php
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">


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


<body class="font-[poppins] bg-gray-50 text-gray-800">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="max-w-xl mx-auto p-8 bg-white mt-10 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-green-600 mb-6">Edit Culinary Trend</h1>

        <form action="/foodfusion/admin/editCulinaryTrend" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            <input type="hidden" name="id" value="<?= $trend['trend_id'] ?>">
            <div>
                <label class="font-medium">Title</label>
                <input type="text" name="trend_title" value="<?= htmlspecialchars($trend['trend_title']) ?>"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="font-medium">Description</label>
                <textarea name="trend_description"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none resize-none focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($trend['trend_description']) ?></textarea>
            </div>

            <div>
                <label class="font-medium">Current Image</label><br>
                <img src="/foodfusion/public/<?= $trend['trend_image'] ?>" alt="Trend Image" class="w-32 rounded mb-3">
                <input type="file" name="trend_image" class="block mt-1">
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Update Trend
            </button>
        </form>
    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
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
    <title>Post New Culinary Trend | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>
    <section class="">

        <div class="m-10 min-h-screen flex items-center justify-center flex-col  px-4 sm:px-6 lg:px-8 ">
            <h1 class="text-center text-2xl  text-green-600  font-bold mb-4">Post New Culinary Trend</h1>

            <form action="foodfusion/admin/postCulinaryTrends" method="POST" enctype="multipart/form-data"
                class=" bg-white p-6 w-full ">
                <div class="flex flex-col items-center justify-start mr-5  ">
                    <div class=" mb-4 rounded-2xl shadow-md">
                        <!-- Current profile image -->
                        <?php if (!empty($errors['trend_image'])): ?>
                        <img class="w-100 h-100 object-cover rounded-2xl " id="trend_imagePreview"
                            src="/foodfusion/public/<?= $old['trend_image']; ?>" alt="Recipe Photo"
                            style="border-radius: 8px;">
                        <?php else: ?>
                        <img class="w-90 h-90 object-cover rounded-md" id="trend_imagePreview"
                            src="/foodfusion/public/uploads/trends/default_d.png" alt="Trend" width="150">
                        <?php endif; ?>
                    </div>

                    <div>
                        <?php if (!empty($errors['trend_image'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['trend_image']) ?>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="trend_image" id="trend_image" class="hidden">

                        <!-- Custom upload button -->
                        <label for="trend_image"
                            class="inline-block bg-[#bef264] mx-10 mb-5 px-4 py-2 rounded-lg cursor-pointer hover:bg-[#f6ffe6] hover:text-gray-600 shadow-md duration-300 transition">
                            Upload Culinary Trend Photo
                        </label>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label for="trend_title" class="block text-sm text-[#111827] font-medium">Culinary Trend
                            Title</label>
                        <?php if (!empty($errors['trend_title'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['trend_title']) ?>
                        </div>
                        <?php endif; ?>
                        <input type="text" name="trend_title" id="trend_title" placeholder="Enter recipe title"
                            class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['trend_title'])?htmlspecialchars($old['trend_title']?? ''):''?>">
                    </div>

                    <div class="mb-4">
                        <label for="trend_description" class="block text-sm text-[#111827] font-medium">Culinary
                            Trend
                            Description</label>
                        <?php if (!empty($errors['trend_description'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['trend_description']) ?>
                        </div>
                        <?php endif; ?>
                        <textarea type="text" rows="8" name="trend_description" id="trend_description"
                            placeholder="Enter culinary trend description"
                            class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                            value="<?= empty($errors['trend_description'])?htmlspecialchars($old['trend_description']?? ''):''?>"><?=!empty($errors['trend_description']) ? '' : htmlspecialchars($old['trend_description'] ?? '') ?>
                        </textarea>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-100 shadow-md hover:text-green-600 flex justify-center text-white font-semibold py-2 
                        px-4 rounded-md  transition duration-300 ">Post
                        Culinary Trend</button>
                </div>
            </form>
        </div>
    </section>
    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

    <script>
    document.getElementById('trend_image').addEventListener('change', function(e) {
        const preview = document.getElementById('trend_imagePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>
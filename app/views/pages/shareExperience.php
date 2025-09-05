<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user'])) {
    header('Location: /foodfusion/public/login');
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
    <title>Share Culinary Experience | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
    @keyframes fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }
    .animate-fadeIn {
        animation: fadeIn 1s ease-in forwards;
    }
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }
    </style>

</head>

<body class="font-[poppins] bg-gray-50 text-gray-800 object-cover  opacity-0 animate-fadeIn">
    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>
    <section class="">

        <div class="m-10 min-h-screen flex items-center justify-center flex-col  px-4 sm:px-6 lg:px-8 ">
            <h1 class="text-center text-2xl  text-green-600  font-bold mb-4">Post New Culinary Experience</h1>

            <form action="foodfusion/public/shareExperience" method="POST" enctype="multipart/form-data"
                class=" p-6 w-full ">
                <div class="flex flex-col items-center justify-start mr-5  ">
                    <div class=" mb-4 rounded-2xl shadow-md">
                        <?php if (!empty($errors['image_path'])): ?>
                        <img class="w-100 h-100 object-cover rounded-2xl " id="imagePreview"
                            src="/foodfusion/public/<?= $old['image_path']; ?>" alt="Recipe Photo"
                            style="border-radius: 8px;">
                        <?php else: ?>
                        <img class="w-90 h-90 object-cover rounded-md" id="imagePreview"
                            src="/foodfusion/public/uploads/trends/default_d.png" alt="Trend" width="150">
                        <?php endif; ?>
                    </div>
                    <div> 
                        <?php if (!empty($errors['image_path'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['image_path']) ?>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="image_path" id="image_path" class="hidden">

                        <!-- Custom upload button -->
                        <label for="image_path"
                            class="inline-block bg-[#bef264] mx-10 mb-5 px-4 py-2 rounded-lg cursor-pointer hover:bg-[#f6ffe6] hover:text-gray-600 shadow-md duration-300 transition">
                            Upload Culinary Experience Photo
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm text-[#111827] font-medium">Experience Title</label>
                    <?php if (!empty($errors['title'])): ?>
                    <div class=" text-red-500 text-sm py-1 ">
                        <?= htmlspecialchars($errors['title']) ?>
                    </div>
                    <?php endif; ?>
                    <input type="text" name="title" id="title" placeholder="Enter experience title"
                        class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                        value="<?= empty($errors['title'])?htmlspecialchars($old['title']?? ''):''?>">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm text-[#111827] font-medium">What's your culinary
                        experience?</label>
                    <?php if (!empty($errors['description'])): ?>
                    <div class=" text-red-500 text-sm py-1 ">
                        <?= htmlspecialchars($errors['description']) ?>
                    </div>
                    <?php endif; ?>
                    <textarea type="text" rows="4" name="description" id="description"
                        placeholder="share your experience"
                        class="resize-none flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "><?= !empty($errors['description']) ? '' : htmlspecialchars($old['description'] ?? '') ?></textarea>
                </div>
                <a href="communityCookBook" class="inline-block pt-5 mr-5 hover:underline text-sm text-green-500">
                    <- Back to Community Cook Book</a>
                        <button type="submit"
                            class=" bg-green-600 hover:bg-green-100 hover:cursor-pointer  shadow-md hover:text-green-600  justify-end items-baseline text-white font-semibold inline-block py-2 px-4 rounded-md  transition duration-300 ">Post
                            Experience
        </div>
        </form>
        </div>

    </section>
    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

    <script>
    document.getElementById('image_path').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".fade-up");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
            }
        );
        cards.forEach((card) => {
            observer.observe(card);
        });
    });
    </script>
</body>
</html>
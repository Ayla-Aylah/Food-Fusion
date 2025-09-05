<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Culinary Resources | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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

<body
    class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen text-gray-800 object-cover bg-no-repeat font-[Poppins] opacity-0 animate-fadeIn">

    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="text-center py-16 px-6">
        <h1 class="text-4xl font-bold text-green-800 mb-3">🍳 Culinary Resources</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">Discover downloadable recipe cards, video tutorials, and
            practical kitchen hacks for every skill level.</p>
    </section>
    <section>
        <div class="flex items-center justify-center gap-5 mb-5">
            <img src="/foodfusion/public/icons/route-solid.svg" class="w-10" alt="">
            <h3 class="text-green-600 text-xl text-center font-semibold">Navigation</h3>
        </div>
        <div class="mb-5 flex flex-wrap items-center justify-center gap-3 sm:gap-4 md:gap-5">
            <a href="#" onclick="scrollToSection('recipes')"
                class="hover:underline px-4 py-2 bg-green-100 text-green-600 shadow-md rounded-full text-sm sm:text-base text-center">
                Go to Recipes Section
            </a>
            <a href="#" onclick="scrollToSection('tuto')"
                class="hover:underline px-4 py-2 bg-green-200 text-green-600 shadow-md rounded-full text-sm sm:text-base text-center">
                Go to Cooking Tutorials Section
            </a>
            <a href="#" onclick="scrollToSection('hacks')"
                class="hover:underline px-4 py-2 bg-green-500 text-white shadow-md rounded-full text-sm sm:text-base text-center">
                Go to Kitchen Hacks Section
            </a>
            <a href="#" onclick="scrollToSection('info')"
                class="hover:underline px-4 py-2 bg-green-600 text-white shadow-md rounded-full text-sm sm:text-base text-center">
                Go to Culinary Infographic Section
            </a>
        </div>


    </section>


    <div class="max-w-7xl mx-auto px-6 py-12 space-y-20">
        <!-- 📑 Recipe Cards -->
        <section id="recipes">
            <h2 class=" text-3xl font-semibold fade-up text-green-700 mb-8">📑 Downloadable Recipe Cards</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($recipeCards as $recipe): ?>
                <div class="bg-white shadow-md rounded-2xl overflow-hidden fade-up hover:shadow-xl transition">
                    <img src="/foodfusion/public/<?= htmlspecialchars($recipe['cover_photo']) ?>"
                        alt="<?= htmlspecialchars($recipe['title']) ?>" class="w-full h-48 object-cover">

                    <div class="p-5 space-y-3">
                        <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($recipe['title']) ?></h3>
                        <p class="text-sm text-gray-500"><?= htmlspecialchars($recipe['cuisine'] ?? 'N/A') ?> |
                            <?= htmlspecialchars($recipe['diet'] ?? 'N/A') ?></p>
                        <div class="flex justify-between items-center text-xs text-gray-600">
                            <span
                                class="bg-green-100 text-green-800 px-2 py-1 rounded-full"><?= htmlspecialchars($recipe['difficulty']) ?></span>
                            <span>🎯 <?= htmlspecialchars($recipe['cooking_time']) ?> mins</span>
                        </div>
                        <div class="flex justify-center items-center text-xs text-gray-600">
                            <span class="text-justify"> <?= htmlspecialchars($recipe['description']) ?> </span>
                        </div>
                        <a href="/foodfusion/public/download/<?= urlencode(basename($recipe['file_path'])) ?>?type=resources"
                            class="block bg-green-600 bottom-0 mt-auto text-white text-center text-sm font-medium py-2 rounded-lg hover:bg-green-700 transition justify-start">📥
                            Download</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 🎥 Cooking Tutorials -->
        <section id="tuto">
            <h2 class="text-3xl font-semibold text-green-700 mb-8">🎥 Cooking Tutorials</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($tutorials as $tutorial): ?>
                <div class="bg-white shadow-md fade-up rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <video controls class="w-full h-56 object-cover">
                        <source src="/foodfusion/public/<?= htmlspecialchars($tutorial['video_link']) ?>"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold text-green-800"><?= htmlspecialchars($tutorial['title']) ?>
                        </h3>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($tutorial['description']) ?></p>
                        <a href="/foodfusion/public/download/<?= urlencode(basename($tutorial['video_link'])) ?>?type=videos"
                            class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition">
                            Download
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 🛠️ Kitchen Hacks -->
        <section id="hacks">
            <h2 class="text-3xl font-semibold fade-up text-green-700 mb-8">🛠️ Kitchen Techniques & Hacks</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($hacks as $hack): ?>
                <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <video controls class="w-full h-56 object-cover">
                        <source src="/foodfusion/public/<?= htmlspecialchars($hack['video_link']) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold text-green-800"><?= htmlspecialchars($hack['title']) ?></h3>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($hack['description']) ?></p>
                        <a href="/foodfusion/public/download/<?= urlencode(basename($hack['video_link'])) ?>?type=videos"
                            class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition">
                            Download
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Infographics -->
        <section id="info">
            <div class="mb-16">
                <h2 class="text-3xl font-semibold text-green-600 mb-8">🖼️ Infographics Library</h2>
                <div class="grid gap-8 lg:grid-cols-2">
                    <?php if (!empty($infographics)): ?>
                    <?php foreach ($infographics as $infographic): ?>
                    <div
                        class="p-5 group bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-md border border-gray-200 transition-transform transform hover:scale-105 hover:shadow-2xl flex justify-center items-center duration-300 cursor-pointer overflow-hidden">
                        <img src="/foodfusion/public/<?= htmlspecialchars($infographic['image']) ?>"
                            alt="<?= htmlspecialchars($infographic['title']) ?>"
                            class="w-64 object-cover h-full rounded-3xl group-hover:brightness-90 transition duration-300"
                            loading="lazy">

                        <div class=" w-1/2 flex flex-col ml-3 h-auto justify-center items-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">
                                <?= htmlspecialchars($infographic['title']) ?>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 overflow-y-auto">
                                <?= htmlspecialchars($infographic['description']) ?></p>
                            <a href="/foodfusion/public/download/<?= urlencode(basename($infographic['image'])) ?>?type=videos"
                                class="mt-auto inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm px-2 py-1 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 3v9" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-gray-500">No infographics available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>

    <?php include_once __DIR__.'/../partials/footer.php'; ?>
    <!-- Animation JS -->
    <script>
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
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".fade-up");

        cards.forEach((card) => {
            const glowCursor = card.querySelector(".glowing-cursor");

            card.addEventListener("mousemove", (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                glowCursor.style.left = `${x}px`;
                glowCursor.style.top = `${y}px`;
                glowCursor.classList.remove("opacity-0");
                glowCursor.classList.add("opacity-100");

                card.style.background =
                    `radial-gradient(960px circle at ${x}px ${y}px, rgba(0,255,1, 0.15), transparent 20%)`;
            });

            card.addEventListener("mouseleave", () => {
                glowCursor.classList.remove("opacity-100");
                glowCursor.classList.add("opacity-0");
                card.style.background = "none";
            });
        });

        const fadeUpCards = document.querySelectorAll(".fade-up");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            }
        );

        fadeUpCards.forEach((card) => observer.observe(card));
    });

    function scrollToSection(id) {
        const element = document.getElementById(id);
        element.scrollIntoView({
            behavior: 'smooth'
        });
    }
    </script>

</body>

</html>
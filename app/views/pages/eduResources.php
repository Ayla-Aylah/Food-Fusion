<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Educational Resources | FoodFusion</title>
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
    class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen text-gray-800 object-cover font-[Poppins] opacity-0 animate-fadeIn">

    <?php include_once __DIR__.'/../partials/header.php'; ?>

    <section class="px-3 py-14 max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold text-green-700 mb-12">🌿 Renewable Energy Educational Resources</h1>
        <section>
            <div class="flex items-center justify-center gap-5 mb-5">
                <img src="/foodfusion/public/icons/route-solid.svg" class="w-10" alt="">
                <h3 class="text-green-600 text-xl text-center font-semibold">Navigation</h3>
            </div>

            <div class="mb-10 flex items-center justify-center gap-5">
                <a href="#" onclick="scrollToSection('PDF')"
                    class="hover:underline px-4 py-2 bg-green-100 text-green-600 shadow-md rounded-full text-sm sm:text-base text-center">Go
                    to Downloadable PDFs</a>
                <a href="#" onclick="scrollToSection('info')"
                    class="hover:underline px-4 py-2 bg-green-200 text-green-600 shadow-md rounded-full text-sm sm:text-base text-center">Go
                    to Culinary Infographic
                    Section</a>
                <a href="#" onclick="scrollToSection('tuto')"
                    class="hover:underline px-4 py-2 bg-green-600 text-white shadow-md rounded-full text-sm sm:text-base text-center">Go
                    to Video Tutorials & Guides
                    Section</a>

            </div>

        </section>
        <!-- Downloadable  Cards -->
        <div id="PDF" class=" mb-16">
            <h2 class="text-3xl font-semibold text-green-600 mb-8">📑 Downloadable PDFs</h2>
            <div class="grid gap-8 lg:grid-cols-2  ">
                <?php if (!empty($downloads)): ?>
                <?php foreach ($downloads as $download): ?>
                <div
                    class="bg-white rounded-3xl flex overflow-hidden border border-gray-200 shadow-lg transition transform hover:scale-105 hover:shadow-xl duration-300 fade-up">
                    <div class="relative overflow-hidden w-7xl">
                        <img src="/foodfusion/public<?= htmlspecialchars($download['cover_image']) ?>"
                            alt="<?= htmlspecialchars($download['title']) ?>"
                            class="w-60 h-80 object-cover rounded-3xl m-5" />
                    </div>
                    <div class="p-5 flex flex-col ">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3"><?= htmlspecialchars($download['title']) ?>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 overflow-y-auto">
                            <?= htmlspecialchars($download['description']) ?></p>
                        <a href="/foodfusion/public/download/<?= urlencode(basename($download['file_path'])) ?>?type=resources"
                            class="mt-auto bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-green-700 transition">📥
                            Download</a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-gray-500">No resources found for the selected filters.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Infographics -->
        <div id="info" class="mb-16">
            <h2 class="text-3xl font-semibold text-green-600 mb-8">🖼️ Infographics Library</h2>
            <div class="grid gap-8 lg:grid-cols-2">
                <?php if (!empty($infographics)): ?>
                <?php foreach ($infographics as $infographic): ?>
                <div
                    class="group p-5 bg-white rounded-3xl fade-up shadow-lg border border-gray-200 transition transform hover:scale-105 hover:shadow-xl flex duration-300 justify-center items-center ">
                    <img src="/foodfusion/public/<?= htmlspecialchars($infographic['file_path']) ?>"
                        alt="<?= htmlspecialchars($infographic['title']) ?>"
                        class="w-1/2 h-w m-2 object-cover rounded-3xl group-hover:brightness-90 transition duration-300">

                    <div class=" w-1/2 flex flex-col ml-3 h-auto justify-center items-center">
                        <h3 class="text-lg font-bold text-gray-800 mb-3"><?= htmlspecialchars($infographic['title']) ?>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 overflow-y-auto">
                            <?= htmlspecialchars($infographic['description']) ?></p>
                        <a href="/foodfusion/public/download/<?= urlencode(basename($infographic['file_path'])) ?>?type=infographics"
                            class="mt-auto inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 
                            rounded-lg transition">
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

        <!-- Video Resources -->
        <div id="tuto">
            <h2 class=" text-3xl font-semibold text-green-600 mb-8">🎥 Video Tutorials & Guides</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 fade-up">
                <?php foreach ($videos as $video): ?>
                <div
                    class="bg-white rounded-3xl shadow-lg overflow-hidden transition transform hover:scale-105 hover:shadow-xl duration-300">
                    <div class="relative group">
                        <video controls class="w-full h-56 object-cover rounded-t-3xl">
                            <source src="/foodfusion/public/<?= htmlspecialchars($video['file_path']) ?>"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <span
                            class="absolute top-3 left-3 bg-green-200 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Video</span>
                    </div>
                    <div class="p-5 flex flex-col h-[220px]">
                        <h3 class="text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($video['title']) ?></h3>
                        <p class="text-gray-600 text-sm mb-4 overflow-y-auto">
                            <?= htmlspecialchars($video['description']) ?></p>
                        <div class="flex items-center justify-between mt-auto">
                            <span
                                class="text-xs text-gray-500"><?= date("F j, Y", strtotime($video['created_at'])) ?></span>
                            <a href="/foodfusion/public/download/<?= urlencode(basename($video['file_path'])) ?>?type=videos"
                                class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-2 rounded-lg transition">Download</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
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
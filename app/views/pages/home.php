<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$joinErrors = $_SESSION['join_errors'] ?? [];
$joinOld = $_SESSION['join_old'] ?? [];
$fromCTA = $_SESSION['from_cta'] ?? false;
unset($_SESSION['join_errors'], $_SESSION['join_old'], $_SESSION['from_cta']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    .hero-overlay::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7));
        z-index: 1;
    }

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
    </style>

</head>

<body class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen object-cover bg-no-repeat text-gray-800 font-[Poppins] opacity-0
     animate-fadeIn">

    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <!-- Hero Section -->
    <section class="
    bg-[url('http://localhost:8080/foodfusion/public/images/base-vecteezy_the-appetizer-in-a-mediterranean-kitchen-is-shrimp-skewers_27099815.jpg')]
    sm:bg-[url('http://localhost:8080/foodfusion/public/images/sm-vecteezy_the-appetizer-in-a-mediterranean-kitchen-is-shrimp-skewers_27099815.jpg')]
    md:bg-[url('http://localhost:8080/foodfusion/public/images/md-vecteezy_the-appetizer-in-a-mediterranean-kitchen-is-shrimp-skewers_27099815.jpg')]
    lg:bg-[url('http://localhost:8080/foodfusion/public/images/lg-vecteezy_the-appetizer-in-a-mediterranean-kitchen-is-shrimp-skewers_27099815.jpg')]
    xl:bg-[url('http://localhost:8080/foodfusion/public/images/vecteezy_the-appetizer-in-a-mediterranean-kitchen-is-shrimp-skewers_27099815.jpg')]
    bg-cover bg-center py-32 text-center flex justify-center lg:justify-end items-center">
        <div class="h-70 p-6 xl:mr-5  lg:backdrop-blur-none">
            <!-- A brief introduction to FoodFusion's mission -->
            <h2
                class="text-white lg:text-[#111827] font-bold mb-4 lg:backdrop-blur-none backdrop-blur-sm rounded-md text-2xl">
                FoodFusion's mission</h2>
            <p class="text-white lg:text-[#111827]  backdrop-blur-sm text-shadow-lg text-lg mb-2 text-justify">
                FoodFusion connects home chefs and foodies around the world.<br> Our mission is to inspire creativity in
                the kitchen through <br> diverse recipes, cultural exchange, and community-powered cooking.
            </p>
            <button onclick="openJoinModal()"
                class="bg-green-600 text-white font-semibold px-6 py-2 rounded-md shadow-md hover:bg-green-100 hover:text-green-600 duration-300 transition">
                Join Us
            </button>
            <!-- Join Us Pop Up Form Modal -->
            <div id="joinModal"
                class="backdrop-blur-xs bg-black/20 fixed inset-0 z-50 hidden bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg relative max-h-[90vh] overflow-y-auto p-6">

                    <!-- Close Button -->
                    <button onclick="closeJoinModal()"
                        class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                        aria-label="Close">
                        &times;
                    </button>

                    <!-- Join Us Heading -->
                    <h2 class="text-2xl font-bold mb-4 text-center text-green-600 ">Join FoodFusion</h2>
                    <!-- Join Us Pop Up Form -->
                    <form action="/foodfusion/public/register" method="POST" class="space-y-4">
                        <input type="hidden" name="source" value="joinus" />
                        <div> <?php if (!empty($joinErrors['first_name'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['first_name']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="first_name" placeholder="First Name"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= empty($joinErrors['first_name'])?htmlspecialchars($joinOld['first_name']?? ''):''?>" />
                        </div>
                        <div>
                            <?php if (!empty($joinErrors['last_name'])): ?>
                            <div class=" text-red-500 text-sm text-left">
                                <?= htmlspecialchars($joinErrors['last_name']) ?>
                            </div>
                            <?php endif; ?><input type="text" name="last_name" placeholder="Last Name"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= empty($joinErrors['last_name'])?htmlspecialchars($joinOld['last_name']?? ''):''?>" />
                        </div>
                        <div>
                            <?php if (!empty($joinErrors['username'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['username']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="username" placeholder="Username"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= empty($joinErrors['username'])?htmlspecialchars($joinOld['username']?? ''):''?>" />
                        </div>

                        <div><?php if (!empty($joinErrors['email'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['email']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="email" placeholder="Email"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                                value="<?= empty($joinErrors['email'])?htmlspecialchars($joinOld['email']?? ''):''?>" />
                        </div>
                        <div>
                            <?php if (!empty($joinErrors['password'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['password']) ?>
                            </div>
                            <?php endif; ?><input type="password" name="password" placeholder="Password"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= empty($joinErrors['password'])?htmlspecialchars($joinOld['password']?? ''):''?>" />
                        </div>
                        <div>
                            <?php if (!empty($joinErrors['confirm_password'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['confirm_password']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="password" name="confirm_password" placeholder="Confirm your password"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= empty($joinErrors['confirm_password'])?htmlspecialchars($joinOld['confirm_password']?? ''):''?>" />
                        </div>

                        <?php if (!empty($errors['recaptcha'])): ?>
                        <div class=" text-red-500 text-sm py-1 ">
                            <?= htmlspecialchars($errors['recaptcha']) ?>
                        </div>
                        <?php endif; ?>
                        <div class="flex justify-center items-center flex-col my-5">
                            <div class="g-recaptcha" data-sitekey="6LeiYnMrAAAAAA9Oo2BycrHlWe2_m0lE633CjynI"
                                class="my-5"></div>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        </div>
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>


                        <div> <?php if (!empty($joinErrors['terms'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($joinErrors['terms']) ?>
                            </div>
                            <?php endif; ?>
                            <div class="flex items-center mb-4">
                                <label class="flex items center mb-4"></label>
                                <input type="checkbox" name="terms" id="terms"
                                    class="mr-2 rounded-md bg-white   accent-green-600 focus-within:outline-[#bef264]">
                                <span class="text-sm text-[#111827]">I agree to the <a href="terms"
                                        class="text-[#16a34a] hover:underline">terms and
                                        conditions</a></span>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="form_type" value="register">
                        <button type="submit"
                            class="w-full bg-green-600 text-white font-semibold py-2 rounded hover:bg-green-700 transition">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Pop Up AutoLoad when there are data validation errors -->
        <?php if (!empty($fromCTA)): ?>
        <script>
        window.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('joinModal');
            if (modal) modal.classList.remove('hidden');
        });
        </script>
        <?php endif; ?>
        <!-- Cookie Consent Banner -->
        <div id="cookie-banner"
            class="fixed bottom-5 left-5 right-5 md:left-10 md:right-10 bg-white/70 backdrop-blur-lg shadow-xl border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-center justify-between gap-4 z-50 animate-fadeIn opacity-0 transition-all duration-500">

            <div class="flex items-center gap-3 text-gray-700">
                <div class="text-2xl">🍪</div>
                <p class="text-center md:text-left">
                    We use cookies to personalize your experience. View our
                    <a href="/foodfusion/public/privacy" class="text-green-600 underline hover:text-green-800">Privacy
                        Policy</a>
                    and
                    <a href="/foodfusion/public/cookiePolicy"
                        class="text-green-600 underline hover:text-green-800">Cookie Policy</a>.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="acceptCookies()"
                    class="bg-green-600 text-white font-medium px-5 py-2 rounded-lg shadow hover:bg-green-700 hover:scale-[1.03] transition duration-300">
                    Accept All
                </button>
                <button onclick="document.getElementById('cookie-banner').style.display='none'"
                    class="text-gray-500 hover:text-gray-700 text-sm md:text-base">Decline</button>
            </div>
        </div>
    </section>
    <!-- Featured Recipe Grid -->
    <section class="container mx-auto px-4 py-5">
        <h1 class="m-5 font-bold  text-3xl text-green-600 text-center">Featured Recipes</h1>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php if (!empty($featuredRecipes)): ?>
            <?php foreach ($featuredRecipes as $recipe): ?>
            <div
                class=" rounded-[16px] shadow-[0_4px_30px_rgba(0,0,0,0.1)] fade-up bg-white/70 backdrop-blur-md border border-[#FFFFFF63] overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] ">
                <!-- Glowing cursor -->
                <div
                    class="glowing-cursor pointer-events-none absolute w-6 h-6 rounded-full bg-green-400/70 shadow-[0_0_12px_6px_rgba(0,255,106,0.7)] opacity-0 transition-opacity duration-150 -translate-x-1/2 -translate-y-1/2">
                </div>
                <div class="relative overflow-hidden rounded-2xl flex justify-center items-center">
                    <img src="/foodfusion/public<?= htmlspecialchars($recipe['image_path']) ?>"
                        alt="<?= htmlspecialchars($recipe['title']) ?>" class="m-5 w-70 h-50 rounded-2xl object-cover ">
                </div>

                <div class="px-5 pb-5">
                    <h3 class="text-lg font-semibold text-gray-800 duration-300 hover:text-green-600 transition">
                        <?= htmlspecialchars($recipe['title']) ?>
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        <?= htmlspecialchars($recipe['cuisine_type'] ?? 'N/A') ?> |
                        <?= htmlspecialchars($recipe['dietary_preference'] ?? 'N/A') ?>
                    </p>
                    <div class="flex justify-between items-center mt-3 text-xs text-gray-600">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md">
                            <?= htmlspecialchars($recipe['description']) ?>
                        </span>
                    </div>

                    <a href="/foodfusion/public/recipeDetails?id=<?= $recipe['id'] ?>"
                        class="mt-4 inline-block text-sm text-green-700 font-medium hover:underline">
                        View Recipe →
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-500">No recipes found for the selected filters.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Culinary Trends -->
    <section class="container mx-auto px-4 py-12">
        <h2 class="text-3xl md:text-4xl font-bold text-green-600 text-center mb-8">Culinary Trends</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach($trends as $trend): ?>
            <div
                class="bg-white shadow hover:shadow-xl rounded-lg overflow-hidden fade-up border border-transparent hover:border-green-400">
                <img src="/foodfusion/public/<?= htmlspecialchars($trend['trend_image']) ?>"
                    class="h-48 w-full object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-green-700"><?= htmlspecialchars($trend['trend_title']) ?></h3>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($trend['trend_description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Event Carousel -->
    <section class="container relative px-4 py-12">
        <h2 class="text-3xl md:text-4xl font-bold text-green-600 text-center mb-8">Upcoming Cooking Events</h2>
        <div class="swiper mySwiper ">
            <div class="swiper-wrapper">
                <?php foreach ($events as $event): ?>
                <div class="swiper-slide">
                    <div class="relative overflow-hidden rounded-xl">
                        <img src="/foodfusion/public<?= htmlspecialchars($event['event_image']) ?>"
                            class="w-full h-150 object-cover">
                        <div
                            class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-white text-center p-6">
                            <h3 class="text-2xl font-bold mb-2"><?= htmlspecialchars($event['title']) ?></h3>
                            <p class="mb-3"><?= htmlspecialchars($event['description']) ?></p>
                            <span class="text-sm mb-3">📅
                                <?= date('F j, Y H:i', strtotime($event['event_date'])) ?></span>
                            <?php if (!empty($event['registration_link'])): ?>
                            <a href="<?= htmlspecialchars($event['registration_link']) ?>"
                                class="bg-green-600 px-4 py-2 rounded hover:bg-green-700">Register</a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>



    <?php include_once __DIR__.'/../partials/footer.php'; ?>

    <!--  Modal Open/Close Functionality for Join Modal -->
    <script>
    const modal = document.getElementById('joinModal');
    window.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('joinModal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    });

    function openJoinModal() {
        modal.classList.remove('hidden');
    }

    function closeJoinModal() {
        modal.classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeJoinModal();
        }
    });

    function acceptCookies() {
        document.getElementById('cookie-banner').style.display = 'none';
        document.cookie = "cookies_accepted=true; path=/; max-age=31536000"; // 1 year
    }

    window.addEventListener('DOMContentLoaded', () => {
        if (document.cookie.includes("cookies_accepted=true")) {
            document.getElementById('cookie-banner').style.display = 'none';
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

    var swiper = new Swiper(".mySwiper", {
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
    });
    </script>

</body>

</html>
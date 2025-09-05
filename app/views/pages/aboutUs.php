<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
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

    #google_translate_element {
        font-size: 14px;
        padding: 5px;
        border-radius: 8px;
    }

    .goog-te-combo {
        border-radius: 0.5rem;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        background-color: #fff;
        color: #111827;
        font-size: 0.875rem;
    }

    .goog-te-combo:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
    }
    </style>
</head>


<body
    class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen object-cover text-gray-800 font-[Poppins] opacity-0 animate-fadeIn">

    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <section class="w-full">


        <!-- Philosophy -->
        <div
            class="fade-up bg-[url('http://localhost:8080/foodfusion/public/images/AdobeStock_790561196_Preview.jpeg.jpg')] bg-cover bg-center py-20 px-6 text-gray-800 font-[poppins] h-150 flex flex-col justify-center items-start">
            <h2 class="text-4xl font-bold text-green-600 text-center  p-5">FoodFusion’s Culinary Philosophy</h2>

            <p
                class=" text-lg text-justify items-start bg-linear-65 from-white/5 to-white/50 p-5 backdrop-blur-xs rounded-xl text-gray-700 max-w-4xl mb-12 font-medium sm:w-80 md:w-90 lg:w-120 xl:w-150">

                At FoodFusion, we see food as a powerful form of self-expression and cultural connection.
                Our philosophy blends tradition and creativity — we honor the roots of authentic recipes while embracing
                innovation through fusion and experimentation.
                <br>
                We believe cooking is an art, a science, and a story — all in one. Whether traditional or
                experimental, every dish
                represents culture, history, and creativity. FoodFusion is a platform where these stories come
                to life.
            </p>
        </div>



        <!-- Values -->
        <div class="m-10 fade-up">
            <h1 class="p-6 text-green-600 font-semibold text-center text-4xl mb-3">Food Fusion's Core Values</h1>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3">🌍 Cultural Diversity</h3>
                    <p class="text-gray-600">

                        We embrace cuisines from all backgrounds and celebrate the rich traditions, techniques, and
                        stories behind every dish.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3"> 💡 Creativity & Innovation</h3>
                    <p>
                        We encourage experimentation, fusion, and fresh ideas that bring new life to traditional
                        cooking.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3">🧑‍🤝‍🧑 Community & Collaboration</h3>
                    <p class="text-gray-600">
                        FoodFusion is built on connection — a place where people can share recipes, learn from each
                        other, and grow together.
                    </p>
                </div>
                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3">🍃 Sustainability</h3>
                    <p class="text-gray-600">
                        We promote conscious cooking using seasonal, local, and eco-friendly practices wherever
                        possible.
                    </p>
                </div>
                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3">🎓 Accessibility & Education</h3>
                    <p class="text-gray-600">
                        Whether you're a beginner or expert, our platform makes culinary knowledge easy to access,
                        understand, and apply.
                    </p>
                </div>
                <div class="bg-gray-50 p-6 rounded shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-green-600 mb-3">🌿 Quality Over Quantity</h3>
                    <p class="text-gray-600">

                        We focus on meaningful content — carefully crafted recipes, trusted tips, and features that
                        truly serve our users.
                    </p>
                </div>
            </div>
        </div>
        <!-- Team -->
        <div class="fade-up">
            <!-- title -->
            <div class="m-5  p-8">
                <h1 class="text-green-600 font-semibold text-4xl text-center mb-5">Team Behind Food Fusion </h1>
                <p class="font-semibold text-[#111827] text-center w-auto m-10">At FoodFusion, our team is a blend of
                    developers, designers, curators — and chefs. Together, we bring both technical excellence and
                    culinary authenticity to life.</p>
                <div>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 justify-center items-center gap-10 m-10 text-center font-semibold text-xl text-green-600">
                        <?php foreach ($members as $member):?>
                        <div class="">
                            <img src="\foodfusion\public\<?= htmlspecialchars($member['photo'])?>"
                                class="w-full  object-cover rounded-full shadow-md" alt="">
                            <p class="mt-5 mx-5"><?= ($member['position'])?></p>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
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
    </script>
</body>

</html>
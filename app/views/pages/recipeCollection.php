<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipe Collection | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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

<body class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen object-cover  text-gray-800 font-[Poppins] opacity-0
     animate-fadeIn">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="px-8 py-12 max-w-7xl mx-auto ">
        <h1 class=" text-center text-4xl font-bold mb-4 text-green-600">Recipe Collection</h1>
        <p class="text-center mb-10 text-lg text-gray-600">
            Explore curated recipes from around the world. Filter by cuisine, dietary preference, or cooking difficulty.
        </p>

        <!-- Filter Form -->
        <form method="GET" class="flex flex-col md:flex-row flex-wrap gap-4 mb-10 justify-center">

            <div class="flex justify-center items-center ">
                <!-- Recipe Title -->
                <label for="title" class="text-gray-700 mr-2">Recipe Title: </label>
                <input type="text" id="title" name="title" placeholder="Type recipe title (e.g., pizza)"
                    value="<?= htmlspecialchars($searchParams['title'] ?? '') ?>"
                    class="rounded-md bg-white p-2 w-full md:w-auto max-w-xs outline-1 outline-[#16a34a]/30 focus:outline-2 focus:outline-[#bef264] shadow-md"
                    autocomplete="off">
            </div>

            <select name="cuisine"
                class="p-2 border border-green-500/30 outline-1 -outline-offset-1 outline-[#bef264] focus-within:outline-2  hover:border-green-100 shadow-md transition-all duration-300 rounded-md">
                <option value="">All Cuisines</option>
                <optgroup label="Asian Cuisines">
                    <option value="Afghan">Afghan</option>
                    <option value=" Bangladeshi">Bangladeshi</option>
                    <option value="Burmese">Burmese</option>
                    <option value="Cambodian">Cambodian</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Filipino">Filipino</option>
                    <option value="Indian">Indian</option>
                    <option value="Indonesian">Indonesian</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Korean">Korean</option>
                    <option value="Laotian">Laotian</option>
                    <option value="Malaysian">Malaysian</option>
                    <option value="Mongolian">Mongolian</option>
                    <option value="Nepalese">Nepalese</option>
                    <option value="Pakistani">Pakistani</option>
                    <option value="Sri Lankan">Sri Lankan</option>
                    <option value="Taiwanese">Taiwanese</option>
                    <option value="Thai">Thai</option>
                    <option value="Vietnamese">Vietnamese</option>
                </optgroup>

                <optgroup label="European Cuisines">
                    <option value="British">British</option>
                    <option value="Bulgarian">Bulgarian</option>
                    <option value="Croatian">Croatian</option>
                    <option value="Czech">Czech</option>
                    <option value="Dutch">Dutch</option>
                    <option value="Finnish">Finnish</option>
                    <option value="French">French</option>
                    <option value="German">German</option>
                    <option value="Greek">Greek</option>
                    <option value="Hungarian">Hungarian</option>
                    <option value="Irish">Irish</option>
                    <option value="Italian">Italian</option>
                    <option value="Polish">Polish</option>
                    <option value="Portuguese">Portuguese</option>
                    <option value="Romanian">Romanian</option>
                    <option value="Russian">Russian</option>
                    <option value="Spanish">Spanish</option>
                    <option value="Swedish">Swedish</option>
                    <option value="Swiss">Swiss</option>
                    <option value="Turkish">Turkish</option>
                    <option value="Ukrainian">Ukrainian</option>
                </optgroup>

                <optgroup label="Middle Eastern & African Cuisines">
                    <option value="Algerian">Algerian</option>
                    <option value="Egyptian">Egyptian</option>
                    <option value="Ethiopian">Ethiopian</option>
                    <option value="Iranian">Iranian</option>
                    <option value="Iraqi">Iraqi</option>
                    <option value="Israeli">Israeli</option>
                    <option value="Jordanian">Jordanian</option>
                    <option value="Lebanese">Lebanese</option>
                    <option value="Libyan">Libyan</option>
                    <option value="Moroccan">Moroccan</option>
                    <option value="Palestinian">Palestinian</option>
                    <option value="Saudi Arabian">Saudi Arabian</option>
                    <option value="Somali">Somali</option>
                    <option value="Sudanese">Sudanese</option>
                    <option value="Syrian">Syrian</option>
                    <option value="Tunisian">Tunisian</option>
                    <option value="Yemeni">Yemeni</option>
                    <option value="South African">South African</option>
                    <option value="Nigerian">Nigerian</option>
                    <option value="Ghanaian">Ghanaian</option>
                </optgroup>

                <optgroup label="American & Latin Cuisines">
                    <option value="American">American</option>
                    <option value="Argentinian">Argentinian</option>
                    <option value="Brazilian">Brazilian</option>
                    <option value="Caribbean">Caribbean</option>
                    <option value="Chilean">Chilean</option>
                    <option value="Colombian">Colombian</option>
                    <option value="Cuban">Cuban</option>
                    <option value="Dominican">Dominican</option>
                    <option value="Haitian">Haitian</option>
                    <option value="Jamaican">Jamaican</option>
                    <option value="Mexican">Mexican</option>
                    <option value="Peruvian">Peruvian</option>
                    <option value="Puerto Rican">Puerto Rican</option>
                    <option value="Uruguayan">Uruguayan</option>
                    <option value="Venezuelan">Venezuelan</option>
                </optgroup>

                <optgroup label="Oceanian Cuisines">
                    <option value="Australian">Australian</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Polynesian">Polynesian</option>
                    <option value="Hawaiian">Hawaiian</option>
                    <option value="Fijian">Fijian</option>
                    <option value="Samoan">Samoan</option>
                </optgroup>

            </select>

            <select name="diet"
                class="p-2 border border-green-500/30  outline-1 -outline-offset-1 outline-[#bef264] focus-within:outline-2  hover:border-green-100 shadow-md transition-all duration-300 rounded-md">
                <option value="">All Diets</option>
                <option value="None">None (General Diet)</option>
                <option value="Vegetarian">Vegetarian</option>
                <option value="Vegan">Vegan</option>
                <option value="Pescatarian">Pescatarian</option>
                <option value="Lacto-Vegetarian">Lacto-Vegetarian</option>
                <option value="Ovo-Vegetarian">Ovo-Vegetarian</option>
                <option value="Lacto-Ovo Vegetarian">Lacto-Ovo Vegetarian</option>
                <option value="Gluten-Free">Gluten-Free</option>
                <option value="Dairy-Free">Dairy-Free</option>
                <option value="Nut-Free">Nut-Free</option>
                <option value="Low-Carb">Low-Carb</option>
                <option value="Keto">Keto</option>
                <option value="Paleo">Paleo</option>
                <option value="Low-FODMAP">Low-FODMAP</option>
                <option value="Halal">Halal</option>
                <option value="Kosher">Kosher</option>
                <option value="Diabetic-Friendly">Diabetic-Friendly</option>
                <option value="Heart-Healthy">Heart-Healthy</option>
                <option value="Whole30">Whole30</option>
                <option value="Raw Food">Raw Food</option>
            </select>

            <select name="difficulty"
                class="p-2  outline-1 -outline-offset-1 outline-[#bef264]  border border-green-500/30 hover:border-green-100 focus-within:outline-2 shadow-md transition-all duration-300 rounded-md">
                <option value="">All Difficulties</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Moderate</option>
                <option value="Hard">Hard</option>
            </select>

            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-100 hover:text-green-600 transition-all duration-300 curo shadow-md ">Filter</button>
        </form>

        <!-- Recipe Grid -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php if (!empty($filteredRecipes)): ?>
            <?php foreach ($filteredRecipes as $recipe): ?>
            <div
                class=" rounded-[16px] shadow-[0_4px_30px_rgba(0,0,0,0.1)] fade-up bg-white/70 backdrop-blur-md border border-[#FFFFFF63] overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] ">
                <!-- Glowing cursor -->
                <div
                    class="glowing-cursor pointer-events-none absolute w-6 h-6 rounded-full bg-green-400/70 shadow-[0_0_12px_6px_rgba(0,255,106,0.7)] opacity-0 transition-opacity duration-150 -translate-x-1/2 -translate-y-1/2">
                </div>
                <div class="relative overflow-hidden rounded-2xl flex justify-center items-center">
                    <img src="/foodfusion/public<?= htmlspecialchars($recipe['image_path']) ?>"
                        alt="<?= htmlspecialchars($recipe['title']) ?>" class="m-5 w-63 h-48 rounded-2xl object-cover ">
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
                        <span class="bg-green-100 text-green-800 px-2 shadow-sm py-1 rounded-full">
                            <?= htmlspecialchars($recipe['difficulty']) ?>
                        </span>
                        <span class="text-gray-500">🎯<?= htmlspecialchars($recipe['cooking_time']) ?> mins</span>
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

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>

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
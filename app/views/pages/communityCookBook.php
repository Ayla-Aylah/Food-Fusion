<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Cook Book | Food Fusion</title>
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

<body
    class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen text-gray-800 font-[Poppins] opacity-0 object-cover bg-no-repeat animate-fadeIn">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class=" py-12 text-center">
        <h1 class="text-4xl font-bold text-green-800">🍲 Community Cookbook</h1>
        <p class="mt-2 text-lg text-gray-700">Share your favorite recipes, tips, and cooking stories with the FoodFusion
            community!</p>

        <div class="relative inline-block text-left group">
            <button
                class="inline-flex items-center px-5 py-3 bg-green-500 text-white font-medium rounded-lg hover:bg-green-100 transition-all duration-500 mt-4 cursor-pointer shadow-md   hover:text-green-500 ">
                Share to Community
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div
                class="absolute z-10 hidden group-hover:block bg-white border border-gray-200 shadow-lg rounded-md duration-300 transition-all w-56">
                <a href="/foodfusion/public/shareRecipe"
                    class="share-btn block px-4 py-3 text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                    🍳 Share Recipe
                </a>
                <a href="/foodfusion/public/shareTip"
                    class="share-btn block px-4 py-3 text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                    💡 Share Tips
                </a>
                <a href="/foodfusion/public/shareExperience"
                    class="share-btn block px-4 py-3 text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                    📖 Share Culinary Experience
                </a>
            </div>

        </div>

    </section>


    <div class="w-full max-w-4xl mx-auto mt-10">
        <div class="mb-5 flex space-x-6 border-b border-gray-300 justify-center">
            <button onclick="showTab('recipes')" id="tab-recipes"
                class="tab-button pb-2 text-black border-b-2 border-black hover:text-green-600 duration-300 hover:border-green-600 transition-all">
                Recipes</button>

            <button onclick="showTab('tips')" id="tab-tips"
                class="tab-button pb-2 text-gray-600 border-b-2 duration-300  border-transparent hover:text-green-600 hover:border-green-600 transition-all">
                Culinary Tips</button>

            <button onclick="showTab('experiences')" id="tab-experiences"
                class="tab-button pb-2 text-gray-600 border-b-2 duration-300  border-transparent hover:text-green-600 hover:border-green-600 transition-all">
                Culinary Experiences</button>
        </div>
    </div>
    <div id="recipes" class="tab-content m-6">
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
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-100 hover:text-green-600 transition-all duration-300 curo shadow-md">Filter</button>
        </form>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 m-5 xl:grid-cols-4">
            <?php if (!empty($filteredRecipes)): ?>
            <?php foreach ($filteredRecipes as $recipe): ?>
            <div
                class="rounded-[16px] shadow-[0_4px_30px_rgba(0,0,0,0.1)] fade-up bg-white/70 backdrop-blur-md border border-[#FFFFFF63] overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] ">
                <!-- Glowing cursor -->
                <div
                    class="glowing-cursor pointer-events-none absolute w-6 h-6 rounded-full bg-green-400/70 shadow-[0_0_12px_6px_rgba(0,255,106,0.7)] opacity-0 transition-opacity duration-150 -translate-x-1/2 -translate-y-1/2">
                </div>

                <div class="relative overflow-hidden rounded-2xl flex justify-center items-center">
                    <img src="/foodfusion/public<?= htmlspecialchars($recipe['image_path']) ?>"
                        alt="<?= htmlspecialchars($recipe['title']) ?>" class="m-5 w-63 h-48 rounded-2xl object-cover">
                </div>

                <div class="px-5 pb-5">
                    <h3 class="text-lg font-semibold text-gray-800 duration-300 hover:text-green-600 transition">
                        <?= htmlspecialchars($recipe['title']) ?>
                    </h3>

                    <div class="flex justify-start items-center mt-2">
                        <img src="/foodfusion/public/<?= htmlspecialchars($recipe['profile_image'] ?? 'default.png') ?>"
                            class="w-10 mr-2 h-10 rounded-full object-cover" alt="Avatar">
                        <div class="flex-col">
                            <p class="text-gray-600 ml-2 text-xs">
                                <?= htmlspecialchars($recipe['postedby'] ?? 'Unknown') ?></p>
                            <p class="text-gray-500 text-xs ml-1.5">
                                <?= date('F j, Y', strtotime($recipe['created_at'])) ?></p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mt-2">
                        <?= htmlspecialchars($recipe['cuisine_type'] ?? 'N/A') ?> |
                        <?= htmlspecialchars($recipe['dietary_preference'] ?? 'N/A') ?>
                    </p>

                    <div class="flex justify-between items-center mt-3 text-xs text-gray-600">
                        <span
                            class="bg-green-100 text-green-800 px-2 shadow-sm py-1 rounded-full"><?= htmlspecialchars($recipe['difficulty']) ?></span>
                        <span class="text-gray-500">🎯<?= htmlspecialchars($recipe['cooking_time']) ?> mins</span>
                    </div>

                    <a href="/foodfusion/public/communityCookBook/cookbookDetails?id=<?= $recipe['id'] ?>"
                        class="mt-4 inline-block text-sm text-green-700 font-medium hover:underline">
                        View Recipe →
                    </a>

                    <!-- Floating Tag -->
                    <span
                        class="absolute top-7 right-6 bg-green-100 text-green-700 text-xs shadow-md font-semibold px-3 py-1 rounded-full">#Recipe</span>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-500">No recipes found for the selected filters.</p>
            <?php endif; ?>
        </div>
    </div>
    <div id="tips"
        class="tab-content bg-gradient-to-br from-green-50 via-white to-green-100 hidden max-w-7xl mx-auto px-4 py-10">
        <?php if (!empty($tips)): ?>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($tips as $tip): ?>
            <div
                class="fade-up relative bg-white backdrop-blur-md border border-white/30 shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transition-transform duration-500 hover:scale-[1.03] cursor-pointer">
                <!-- Glowing cursor -->
                <div
                    class="glowing-cursor pointer-events-none absolute w-6 h-6 rounded-full bg-green-400/70 shadow-[0_0_12px_6px_rgba(0,255,106,0.7)] opacity-0 transition-opacity duration-150 -translate-x-1/2 -translate-y-1/2">
                </div>

                <!-- Image Section -->
                <div class="relative overflow-hidden h-64">
                    <img src="/foodfusion/public/<?= htmlspecialchars($tip['image_path']) ?>"
                        alt="<?= htmlspecialchars($tip['tip_title']) ?>"
                        class="w-full h-full object-cover transition-transform duration-300" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                    </div>
                    <div class="absolute bottom-4 left-4 text-white z-10">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($tip['tip_title']) ?></h3>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <div class="flex items-center space-x-2">
                            <img src="/foodfusion/public/<?= htmlspecialchars($tip['profile_image'] ?? 'default.png') ?>"
                                alt="<?= htmlspecialchars($tip['postedby'] ?? 'User Avatar') ?>"
                                class="w-12 h-12 rounded-xl object-cover">
                            <span><?= htmlspecialchars($tip['postedby'] ?? 'Unknown') ?></span>
                        </div>
                        <span
                            class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                            <?= date('M j, Y', strtotime($tip['createdat'])) ?>
                        </span>
                    </div>

                    <div class="mt-3 text-gray-900 text-justify">
                        <p class="text-md"><?= htmlspecialchars($tip['tip_description']) ?></p>
                    </div>
                    <div>

                    </div>
                </div>
                <!-- Floating Tag -->
                <span
                    class="absolute top-3 right-3 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    #CulinaryTip
                </span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center text-gray-500 py-10 text-lg">No tips found. Be the first to share a great tip!</div>
        <?php endif; ?>
    </div>

    <div id="experiences"
        class="tab-content bg-gradient-to-br from-green-50 via-white to-green-100 hidden max-w-7xl mx-auto px-4 py-10">
        <?php if (!empty($experiences)): ?>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($experiences as $experience): ?>
            <div
                class="fade-up relative bg-white backdrop-blur-md border border-white/30 shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transition-transform duration-500 hover:scale-[1.03] cursor-pointer">
                <!-- Glowing cursor -->
                <div
                    class="glowing-cursor pointer-events-none absolute w-6 h-6 rounded-full bg-green-400/70 shadow-[0_0_12px_6px_rgba(0,255,106,0.7)] opacity-0 transition-opacity duration-150 -translate-x-1/2 -translate-y-1/2">
                </div>
                <div class="flex justify-between bg-white items-center text-xs text-gray-500">
                    <div class="flex items-center space-x-2  p-5">
                        <img src="/foodfusion/public/<?= htmlspecialchars($experience['profile_image'] ?? 'default.png') ?>"
                            alt="<?= htmlspecialchars($experience['postedby'] ?? 'User Avatar') ?>"
                            class="w-14 h-14 rounded-full object-cover">
                        <span class="ml-2"><?= htmlspecialchars($experience['postedby'] ?? 'Unknown') ?></span>
                    </div>
                    <span class=" text-xs font-semibold px-3 mr-3 py-1 ">
                        <?= date('M j, Y', strtotime($experience['created_at'])) ?>
                    </span>
                </div>

                <!-- Image Section -->
                <div class="relative overflow-hidden h-70">
                    <img src="/foodfusion/public/<?= htmlspecialchars($experience['image_path']) ?>"
                        alt="<?= htmlspecialchars($experience['title']) ?>"
                        class="w-full h-full object-cover transition-transform duration-300" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                    </div>
                    <div class="absolute bottom-4 left-4 text-white z-10">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($experience['title']) ?></h3>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-5 pb-5 bg-white">
                    <div class="mt-3 text-gray-900 text-justify">
                        <p class="text-md"><?= htmlspecialchars($experience['description']) ?></p>
                    </div>
                </div>

                <!-- Floating Tag -->
                <span
                    class="absolute top-26 right-3 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    #Experience
                </span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center text-gray-500 py-10 text-lg">No tips found. Be the first to share a great tip!</div>
        <?php endif; ?>
    </div>
    <!-- Login Required Modal -->
    <div id="loginModal"
        class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center transition-all">
        <div
            class="relative bg-white/90 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-2xl p-8 w-full max-w-sm animate-fade-in-down">

            <!-- Close Button -->
            <button onclick="closeLoginModal()"
                class="absolute top-3 right-3 text-gray-500 cursor-pointer hover:text-red-500 transition text-lg">
                &times;
            </button>

            <!-- Modal Content -->
            <div class="text-center">
                <img src="/foodfusion/public/icons/lock-solid.svg" class="w-8 h-8 mx-auto mb-4 text-green-500"
                    alt="lock icon">

                <h2 class="text-2xl font-bold text-gray-800 mb-2">Login Required</h2>
                <p class="text-gray-600 mb-6">You must log in to like, comment, or save this recipe to favorites.</p>

                <a href="/foodfusion/public/login"
                    class="inline-block w-full bg-green-500 text-white py-2.5 rounded-xl font-semibold hover:bg-green-100 hover:text-green-500  shadow-md transition-all duration-300">
                    🔐 Login Now
                </a>
                <button onclick="closeLoginModal()"
                    class="mt-3 w-full py-2 cursor-pointer hover:text-green-500 text-gray-600 font-medium hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once __DIR__ . '/../partials/footer.php'; ?>
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


    window.showTab = function(tabId) {
        document.querySelectorAll(".tab-content").forEach(tab => tab.classList.add("hidden"));
        document.querySelectorAll(".tab-button").forEach(btn => {
            btn.classList.remove("border-black", "text-black");
            btn.classList.add("text-gray-600", "border-transparent");
        });

        document.getElementById(tabId).classList.remove("hidden");

        const activeTab = document.getElementById("tab-" + tabId);
        if (activeTab) {
            activeTab.classList.remove("text-gray-600", "border-transparent");
            activeTab.classList.add("text-black", "border-black");
        }
    };
    const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".share-btn").forEach(btn => {
            btn.addEventListener("click", function(e) {
                if (!isLoggedIn) {
                    e.preventDefault();
                    showLoginModal();
                }
            });
        });
    });

    function showLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
    }
    // Hide login popup
    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }
    </script>

</body>

</html>
<nav class="bg-white w-full top-0 -z-50 shadow-md">
    <div class="flex justify-between items-center h-16 px-4 md:px-8">
        <!-- Website Logo -->
        <div class="text-xl text-green-600 font-bold">
            <img src="http://localhost:8080/foodfusion/public/images/ff_logo.png" class="inline-block w-20" alt="Logo">
        </div>

        <!-- Desktop Menu -->
        <div class="hidden xl:flex items-center space-x-6 text-gray-700 font-medium relative">
            <a href="/foodfusion/public/" class="hover:text-green-600 text-sm transition duration-300">Home</a>
            <a href="/foodfusion/public/aboutUs" class="hover:text-green-600 text-sm transition duration-300">About
                Us</a>
            <a href="/foodfusion/public/recipeCollection"
                class="hover:text-green-600 text-sm transition duration-300">Recipe
                Collection</a>
            <a href="/foodfusion/public/communityCookBook"
                class="hover:text-green-600 text-sm transition duration-300">Community
                Cookbook</a>
            <a href="/foodfusion/public/contactUs" class="hover:text-green-600 text-sm transition duration-300">Contact
                Us</a>

            <!-- Resources Dropdown -->
            <div class="group relative">
                <button
                    class="flex items-center space-x-1 hover:text-green-600 text-sm transition duration-300 focus:outline-none"
                    id="resources-button" aria-haspopup="true" aria-expanded="false">
                    <span>Resources</span>
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <ul class="absolute left-0  w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-opacity duration-200 z-50"
                    aria-label="submenu" role="menu" aria-labelledby="resources-button">
                    <li>
                        <a href="/foodfusion/public/culinaryResources"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm" role="menuitem">Culinary
                            Resources</a>
                    </li>
                    <li>
                        <a href="/foodfusion/public/educationalResources"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm" role="menuitem">Educational
                            Resources</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Actions -->

        <div id="google_translate_element" class="hidden"></div>
        <div class="flex items-center space-x-4">
            <div class=" items-center space-x-2 ">
                <select id="languageSelect"
                    class="border border-gray-300 text-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">Select Language</option>
                    <option value="en">English</option>
                    <option value="my">Burmese</option>
                    <option value="fr">French</option>
                    <option value="es">Spanish</option>
                    <option value="zh-CN">Chinese</option>
                    <option value="ja">Japanese</option>
                    <option value="de">German</option>
                    <option value="ko">Korean</option>
                    <option value="th">Thai</option>
                </select>
            </div>


            <?php if(isset($_SESSION['user'])): ?>
            <a href="/foodfusion/public/logout"
                class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-100 shadow-md transition duration-300 text-sm">Logout</a>
            <?php else:?>
            <a href="/foodfusion/public/login"
                class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-100 shadow-md transition duration-300 text-sm">Login</a>
            <?php endif; ?>
            <a href="/foodfusion/public/profile">
                <?php if (!empty($user['profile_image'])): ?>
                <img src="/foodfusion/public/<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile Image"
                    class="w-10 h-10 rounded-full object-cover ">
                <?php else: ?>
                <div class="">
                    <img src="http://localhost:8080/foodfusion/public/icons/user-solid.svg" class="w-6 h-6"
                        alt="Profile">
                </div>
                <?php endif; ?>
            </a>

            <!-- Hamburger Menu -->
            <button id="hamburger-btn" class="xl:hidden focus:outline-none">
                <!-- Hamburger icon -->
                <img id="hamburger-icon" src="http://localhost:8080/foodfusion/public/icons/burger-solid.svg"
                    class="w-10 h-10" alt="Menu">
                <!-- Close icon -->
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden xl:hidden bg-white px-6 py-4 shadow-md space-y-2 text-gray-700 font-medium">
        <a href="/foodfusion/public/" class="block hover:text-green-600">Home</a>
        <a href="/foodfusion/public/aboutUs" class="block hover:text-green-600">About Us</a>
        <a href="/foodfusion/public/recipeCollection" class="block hover:text-green-600">Recipe Collection</a>
        <a href="/foodfusion/public/communityCookBook" class="block hover:text-green-600">Community Cookbook</a>
        <a href="/foodfusion/public/contactUs" class="block hover:text-green-600">Contact Us</a>

        <!-- Mobile Resources dropdown -->
        <details class="group">
            <summary
                class="cursor-pointer flex justify-between items-center hover:text-green-600 font-medium list-none">
                Resources
                <svg class="w-4 h-4 mt-1 text-gray-500 group-open:rotate-180 transition-transform duration-200"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>
            <div class="pl-4 mt-2 space-y-1">
                <a href="culinaryResources" class="block hover:text-green-600 ">Culinary Resources</a>
                <a href="educationalResources" class="block hover:text-green-600 ">Educational Resources</a>
            </div>
        </details>
    </div>
</nav>

<script>
// Hamburger menu toggle script 
const btn = document.getElementById('hamburger-btn');
const menu = document.getElementById('mobile-menu');
const hamburgerIcon = document.getElementById('hamburger-icon');
const closeIcon = document.getElementById('close-icon');

btn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
    hamburgerIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
});
</script>
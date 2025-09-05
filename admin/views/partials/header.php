<!-- Responsive Navigation Bar -->
<nav class="bg-white w-full shadow-md top-0 z-50">
    <div class="flex justify-between items-center h-16 px-4 md:px-8">
        <!-- Logo -->
        <div class="text-xl text-green-600 font-bold">
            <img src="http://localhost:8080/foodfusion/public/images/ff_logo.png" class="inline-block w-20" alt="Logo">
        </div>

        <!-- Desktop Menu -->
        <div class="hidden xl:flex items-center space-x-6 text-gray-700 font-medium">
            <a href="/foodfusion/admin/" class="hover:text-green-600 text-sm transition duration-300">Dashboard</a>
            <div class="group relative">
                <button
                    class="flex items-center space-x-1 hover:text-green-600 text-sm transition duration-300 focus:outline-none"
                    id="resources-button" aria-haspopup="true" aria-expanded="false">
                    <span>HomePage</span>
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul
                    class="absolute left-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-opacity duration-200 z-50">
                    <li> <a href="/foodfusion/admin/eventList"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">Events</a></li>
                    <li> <a href="/foodfusion/admin/culinaryTrends"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">Culinary Trends</a>
                    </li>
                </ul>
            </div>


            <a href="/foodfusion/admin/userList" class="hover:text-green-600 text-sm transition duration-300">Users</a>

            <a href="/foodfusion/admin/recipes" class="hover:text-green-600 text-sm transition duration-300">Recipes</a>
            <a href="/foodfusion/admin/teamList" class="hover:text-green-600 text-sm transition duration-300">Team</a>

            <!-- Community Cookbook Dropdown -->
            <div class="group relative">
                <button
                    class="flex items-center space-x-1 hover:text-green-600 text-sm transition duration-300 focus:outline-none"
                    id="resources-button" aria-haspopup="true" aria-expanded="false">
                    <span>Community CookBook</span>
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul
                    class="absolute left-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-opacity duration-200 z-50">
                    <li><a href="/foodfusion/admin/userRecipes"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">User Recipes</a></li>
                    <li><a href="/foodfusion/admin/Tips"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">Tips</a></li>
                    <li><a href="/foodfusion/admin/experiences"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">Experiences</a></li>
                </ul>
            </div>

            <a href="/foodfusion/admin/messages"
                class="hover:text-green-600 text-sm transition duration-300">Messages</a>

            <!-- Resources Dropdown -->
            <div class="group relative">
                <button
                    class="flex items-center space-x-1 hover:text-green-600 text-sm transition duration-300 focus:outline-none">
                    <span>Resources</span>
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul
                    class="absolute left-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-opacity duration-200 z-50">
                    <li><a href="/foodfusion/admin/infoList"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">
                            Culinary Infographics</a></li>
                    <li><a href="/foodfusion/admin/recipeCardList"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">
                            Downloadable Recipes</a></li>
                    <li><a href="/foodfusion/admin/cookingTutorials"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">
                            Cooking Tutorials</a>
                    </li>
                    <li><a href="/foodfusion/admin/hacks"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">
                            Kitchen Techniques and
                            Hacks</a></li>
                    <li><a href="/foodfusion/admin/eduResources"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-700 text-sm">
                            Educational Resources</a></li>
                </ul>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <a href="userView"
                    class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-400 transition duration-300 text-sm">User
                    View</a>
                <?php if(isset($_SESSION['admin'])): ?>
                <a href="/foodfusion/admin/logout"
                    class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-100 shadow-md transition duration-300 text-sm">Logout</a>
                <?php else:?>
                <a href="/foodfusion/admin/login"
                    class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-100 shadow-md transition duration-300 text-sm">Login</a>
                <?php endif; ?>
                <a href="/foodfusion/admin/profile">
                    <img src="http://localhost:8080/foodfusion/public/icons/user-solid.svg" class="w-6 h-6"
                        alt="Profile">
                </a>
            </div>
        </div>

        <!-- Hamburger Button (Visible only on small screens) -->
        <div class="xl:hidden flex items-center">
            <button id="hamburger-btn" class="focus:outline-none">
                <!-- Hamburger Icon -->
                <img id="hamburger-icon" src="http://localhost:8080/foodfusion/public/icons/burger-solid.svg"
                    class="w-10 h-10" alt="Menu">
                <!-- Close Icon -->
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden xl:hidden bg-white px-6 py-4 shadow-md space-y-2 text-gray-700 font-medium">
        <a href="/foodfusion/admin/events" class="block hover:text-green-600">Events</a>
        <a href="/foodfusion/admin/userList" class="block hover:text-green-600">Users</a>
        <a href="/foodfusion/admin/culinaryTrends" class="block hover:text-green-600">Culinary Trend</a>
        <a href="/foodfusion/admin/recipes" class="block hover:text-green-600">Recipes</a>
        <a href="/foodfusion/admin/communitycookbooks" class="block hover:text-green-600">Community Cookbook</a>
        <a href="/foodfusion/admin/messages" class="block hover:text-green-600">Messages</a>
        <a href="#" class="block hover:text-green-600">Resources</a>
        <!-- Actions -->
        <div class="flex items-center space-x-4">
            <a href="userView"
                class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-400 transition duration-300 text-sm">User
                View</a>
            <a href="adminLogin"
                class="text-[#111827] font-bold rounded-md px-3 py-1.5 bg-[#bef264] hover:bg-lime-400 transition duration-300 text-sm">Login</a>
            <a href="profile">
                <img src="http://localhost:8080/foodfusion/public/icons/user-solid.svg" class="w-6 h-6" alt="Profile">
            </a>
        </div>
    </div>
</nav>

<!-- Hamburger Menu Script -->
<script>
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
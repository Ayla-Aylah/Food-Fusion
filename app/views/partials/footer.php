<footer class="bg-[#111827] text-white py-8 mx-3 rounded-t-2xl mt-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start space-y-8 md:space-y-0">

            <!--  Website Name -->
            <div class="flex items-left space-x-3 justify-center lg:justify-start flex-col md:w-1/4 md:mr-5 xl:mr-0">
                <h1 class=" font-semibold text-xl tracking-wide whitespace-nowrap mb-3">FoodFusion</h1>
                <p class="text-justify">
                    🌱 Bringing passionate home cooks and food enthusiasts
                    together to share, discover, and celebrate recipes, culinary tips, and creative kitchen moments from
                    around the world.
                </p>
            </div>

            <!-- Quick Navigation Links -->
            <nav
                class="flex flex-wrap flex-col justify-center lg:justify-center gap-4 md:gap-3 text-sm font-medium mb-5">
                <h1 class="text-lg">Navigation Links</h1>
                <a href="/foodfusion/public/"
                    class="hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded hover:text-[#bef264] text-sm  transition duration-300">Home</a>
                <a href="/foodfusion/public/aboutUs"
                    class="hover:underline hover:text-[#bef264] 0 text-sm  transition duration-300 focus:outline-none focus:ring-2 focus:ring-white rounded">About
                    Us</a>
                <a href="/foodfusion/public/recipeCollection"
                    class="hover:underline hover:text-[#bef264]  text-sm  transition duration-300 focus:outline-none focus:ring-2 focus:ring-white rounded">Recipes</a>
                <a href="/foodfusion/public/contactUs"
                    class="hover:underline focus:outline-none hover:text-[#bef264]  text-sm  transition duration-300 focus:ring-2 focus:ring-white rounded">Contact</a>
                <a href="/foodfusion/public/communityCookBook"
                    class="hover:underline focus:outline-none hover:text-[#bef264]  text-sm  transition duration-300 focus:ring-2 focus:ring-white rounded">Community</a>
            </nav>
            <!-- Legal Links -->
            <div
                class="flex flex-wrap flex-col justify-start lg:justify-center gap-3 md:gap-3 text-sm font-medium mb-5">
                <h1 class=" text-lg">Legal Links</h1>
                <a href="/foodfusion/public/privacy"
                    class="hover:text-[#bef264]  text-sm  transition duration-300 hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded">Privacy
                    Policy</a>
                <a href="/foodfusion/public/terms"
                    class="hover:text-[#bef264] text-sm  transition duration-300 hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded">Terms
                    of Service</a>
                <a href="/foodfusion/public/cookiePolicy"
                    class="hover:text-[#bef264] 0 text-sm  transition duration-300 hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded">Cookie
                    Policy</a>

            </div>
            <!-- Contact Infomation -->
            <address
                class="not-italic flex flex-col items-center md:items-end font-medium space-y-2 text-xs text-center md:text-right">
                <h1 class="text-lg">Contact Information</h1>
                <div class="flex flex-wrap justify-center md:justify-end gap-4 text-xs flex-col">
                    <a href="mailto:info@foodfusion.com"
                        class="hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded"
                        aria-label="Email careers at FoodFusion">
                        📧 Email address - info@foodfusion.com
                    </a>
                    <a href="tel:+44 20 7123 4567"
                        class="hover:underline focus:outline-none focus:ring-2 focus:ring-white rounded"
                        aria-label="Call FoodFusion Careers">
                        ☎️ Phone number - +44 20 7123 4567
                    </a>
                    <p>📍address - 10 Elm Street
                        Anytown
                        OX1 1AB
                        UNITED KINGDOM </p>
                </div>
            </address>
        </div>
        <!-- Social Media Icons and Links -->
        <div class="flex flex-wrap flex-row items-center justify-center m-5">
            <a class="hover:border-[#bef264] text-sm  transition duration-300 border-2 rounded-full p-2 width-10 mr-2"
                href="https://www.facebook.com"> <img class="w-6 h-6"
                    src="http://localhost:8080/foodfusion/public/icons/facebook-f-brands.svg" alt=""></a>
            <a class="hover:border-[#bef264] text-sm  transition duration-300  border-2 rounded-full p-2 width-10 mr-2"
                href="https://www.instagram.com"> <img class="w-6 h-6"
                    src="http://localhost:8080/foodfusion/public/icons/instagram-brands (1).svg" alt=""></a>
            <a class="hover:border-[#bef264]  text-sm  transition duration-300  border-2 rounded-full p-2 width-10 mr-2"
                href="https://www.x.com"> <img class="w-6 h-6"
                    src="http://localhost:8080/foodfusion/public/icons/x-twitter-brands.svg" alt=""></a>
            <a class="hover:border-[#bef264]  text-sm  transition duration-300  border-2 rounded-full p-2 width-10 "
                href="https://www.linkedin.com"> <img class="w-6 h-6"
                    src="http://localhost:8080/foodfusion/public/icons/linkedin-brands.svg" alt=""></a>
        </div>
        <!-- Copyright -->
        <div class=" text-center text-gray-200 text-xs" role="contentinfo" aria-label="Copyright">
            &copy; 2025 FoodFusion. All rights reserved.
        </div>
    </div>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit&hl=en"></script>
    <script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en'
        }, 'google_translate_element');
    }
    document.getElementById('languageSelect').addEventListener('change', function() {
        var language = this.value;
        if (language) {
            var selectField = document.querySelector('.goog-te-combo');
            if (selectField) {
                selectField.value = language;
                selectField.dispatchEvent(new Event('change'));
            }
        }
    });
    </script>


</footer>
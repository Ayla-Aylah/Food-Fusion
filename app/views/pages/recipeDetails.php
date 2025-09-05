<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['error'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en" class="bg-gradient-to-b from-green-50 to-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
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
    class=" bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen text-gray-800 font-[Poppins] opacity-0 animate-fadeIn">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <div id="printable-recipe"
        class="rounded-[16px] shadow-sm fade-up animate-fadeIn bg-white/70  backdrop-blur-md border border-[#FFFFFF63] overflow-hidden transition-all duration-300 hover:shadow-xl max-w-4xl mx-auto p-10 m-6">

        <!-- Title & Image -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-green-600 leading-tight"><?= htmlspecialchars($recipe['title']) ?></h1>
            <div class="flex justify-center items-center">
                <p class="text-sm text-gray-500 mt-4 mr-5">
                    <?= date("F j, Y", strtotime($recipe['created_at'])) ?></p>
            </div>

            <div class="mt-6 rounded-2xl overflow-hidden shadow-lg">
                <img src="/foodfusion/public/<?= htmlspecialchars($recipe['image_path']) ?>"
                    alt="<?= htmlspecialchars($recipe['title']) ?>"
                    class="w-full h-64 sm:h-80 md:h-96 lg:h-[600px] object-cover rounded-md hover:brightness-105 transition-all duration-300">
            </div>
        </div>

        <!-- Quick Details -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm text-gray-600 mb-10">
            <div class="bg-pink-100 text-pink-600 px-4 py-2 rounded-lg shadow-md  font-medium text-center">
                🕒
                <?= htmlspecialchars($recipe['cooking_time']) ?> min</div>
            <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg  shadow-md font-medium text-center">⚡
                <?= htmlspecialchars($recipe['difficulty']) ?></div>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-md font-medium text-center">🌿
                <?= htmlspecialchars($recipe['dietary_preference']) ?></div>
        </div>

        <!-- Description -->
        <section class="mb-10 bg-white shadow-inner rounded-xl p-6 border border-gray-100">
            <h2 class="text-2xl font-semibold mb-3 text-green-600">✨ Description</h2>
            <p class="text-gray-700 text-lg leading-relaxed"><?= nl2br(htmlspecialchars($recipe['description'])) ?>
            </p>
        </section>
        <!-- Cook Mode -->
        <div class="flex items-center justify-center p-4 shadow-sm my-7 rounded-xl">
            <label for="cook-mode"
                class="flex flex-col items-center gap-4 text-xl font-semibold text-green-600 cursor-pointer">
                <span>Cook Mode</span>

                <div class="relative inline-flex items-center">
                    <input type="checkbox" id="cook-mode" class="sr-only peer" onchange="toggleCookMode()">

                    <!-- Track -->
                    <div
                        class="w-14 h-8 bg-gray-300 rounded-full peer-checked:shadow-green-500/50 shadow-md peer-checked:bg-green-500 transition-all duration-300 mr-3">
                    </div>

                    <!-- Circle (Knob) -->
                    <div
                        class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full border shadow-inner border-gray-300 transition-transform duration-300 peer-checked:translate-x-6">
                    </div>
                    <span class="text-sm text-gray-600">Prevent screen from going dark</span>
                </div>
            </label>
        </div>
        <!-- Timer -->
        <div class="text-center m-7">
            <h2 class="text-xl font-semibold text-green-600 mb-2">⏱ Cooking Timer</h2>
            <div class="flex items-center justify-center gap-4 text-lg">
                <span id="timerDisplay" class="font-mono text-3xl text-gray-800">00:00</span>
                <button id="startPauseBtn" onclick="toggleTimer()"
                    class="bg-green-500 cursor-pointer hover:bg-green-100 hover:text-green-500 duration-300 text-white px-4 py-2 rounded-lg shadow-md transition">
                    Start
                </button>
                <button onclick="resetTimer()"
                    class="bg-gray-400 cursor-pointer px-4 text-white shadow-md py-2 rounded-lg transition duration-300 hover:bg-gray-100 hover:text-black">Reset</button>
            </div>
        </div>

        <!-- Ingredients -->
        <section class="mb-10 bg-white shadow-inner rounded-xl p-6 border border-gray-100">
            <h2 class="text-2xl font-semibold mb-3 text-green-600">🧂 Ingredients</h2>
            <ul class="space-y-3 text-lg text-gray-800">
                <?php foreach ($ingredients as $index => $ingredient): ?>
                <li class="flex items-start space-x-3">
                    <input type="checkbox" id="ingredient-<?= $index ?>"
                        class="mt-1 w-5 h-5 accent-green-600 text-green-500 rounded-md border-gray-300 focus:ring-2 focus:ring-green-400 checked:scale-110 transition-all duration-300">
                    <label for="ingredient-<?= $index ?>"
                        class="flex-1 cursor-pointer hover:text-green-700 hover:scale-[1.02] transition-transform duration-200">
                        <?= htmlspecialchars($ingredient['ingredient_name']) ?> -
                        <?= htmlspecialchars($ingredient['quantity']) ?>
                        <?= htmlspecialchars($ingredient['unit']) ?>
                    </label>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Instructions -->
        <section class="mb-10 bg-white shadow-inner rounded-xl p-6 border border-gray-100">
            <h2 class="text-2xl font-semibold mb-3 text-green-600">👨‍🍳 Instructions</h2>
            <ol class="space-y-4 text-lg text-gray-800">
                <?php foreach ($instructions as $index => $instruction): ?>
                <li class="flex items-start space-x-3">
                    <input type="checkbox" id="step-<?= $index ?>"
                        class="mt-1 w-5 h-5 accent-green-600 text-green-500 rounded-md border-gray-300 focus:ring-2 focus:ring-green-400 checked:scale-110 transition-all duration-300">
                    <label for="step-<?= $index ?>"
                        class="flex-1 cursor-pointer hover:text-green-700 hover:scale-[1.02] transition-transform duration-200">
                        <?= htmlspecialchars($instruction['step_text']) ?>
                    </label>
                </li>
                <?php endforeach; ?>
            </ol>
        </section>

        <!-- Tips & Nutrition -->
        <section class="mb-10 bg-white shadow-inner rounded-xl p-6 border border-gray-100">
            <h2 class="text-2xl font-semibold mb-3 text-green-600">💡 Tips & Nutrition</h2>
            <div class="grid sm:grid-cols-2 gap-6 text-base text-gray-700">
                <div class="bg-gray-100 p-4 rounded-xl shadow-md">
                    <h3 class="font-semibold mb-1">Chef's Tip</h3>
                    <p><?= htmlspecialchars($recipe['recipe_tips']) ?></p>
                </div>
                <div class="bg-gray-100 p-4 rounded-xl shadow-md">
                    <h3 class="font-semibold mb-1">Nutrition Info</h3>
                    <p><?= htmlspecialchars($recipe['nutrition']) ?></p>
                </div>
            </div>
        </section>

        <!-- Meta Info -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mt-10">
            <span class="inline-flex items-center bg-blue-100 px-3 py-1 rounded-full  shadow-md">🍽 Cuisine: <span
                    class="ml-2 font-medium"><?= htmlspecialchars($recipe['cuisine_type']) ?></span></span>
            <span class="inline-flex items-center bg-orange-100 px-3 py-1 rounded-full shadow-md">🔥 Difficulty:
                <span class="ml-2 font-medium"><?= htmlspecialchars($recipe['difficulty']) ?></span></span>
            <span class="inline-flex items-center bg-green-100 px-3 py-1 rounded-full shadow-md">🌱 Diet: <span
                    class="ml-2 font-medium"><?= htmlspecialchars($recipe['dietary_preference']) ?></span></span>
        </div>
    </div>
    <div class="recipe">
        <div id="like-section" class="flex  justify-center items-center gap-2 max-w-4xl mx-auto p-10 ">
            <button id="like-btn"
                class="flex items-center cursor-pointer gap-1 px-4 py-2 bg-gray-100 hover:bg-green-500 text-green-500 font-semibold rounded-full hover:text-white duration-300 shadow transition-all"
                data-recipe-id="<?= $recipe['id'] ?>">
                <img class="w-5 mr-2 " src="/foodfusion/public/icons/thumbs-up-solid.svg" alt=""> <span
                    id="like-text"><?= $hasLiked ? 'Liked' : 'Like' ?></span>
            </button>
            <span id="like-count" class="text-sm text-gray-600 mr-10 font-semibold"><?= $likeCount ?> likes</span>

            <button onclick="printDiv('printable-recipe')" class="px-4 py-2 bg-green-500 cursor-pointer mr-10 shadow-md text-white rounded-full
                 hover:bg-green-100 hover:text-green-500 transition-all duration-300">
                <img src="/foodfusion/public/icons/print-solid.svg" class="w-5 inline-block mr-2" alt=""> Print
                Recipe
            </button>


            <button type="submit" id="fav-btn"
                class="px-4 py-2 cursor-pointer bg-pink-200 shadow-md text-pink-600 rounded-full hover:bg-green-200 transition-all duration-300"
                data-recipe-id="<?= $recipe['id'] ?>">
                <span id="fav-text"><?= $hasfav ? '❤️ Saved to Favorites' : '❤️ Save to Favorites' ?></span>
            </button>
            <span id="fav-count" class="text-sm text-gray-600 mr-10 font-semibold"><?= $favCount ?>
                favourites</span>
        </div>

        <?php 
            $recipeUrl = "http://localhost:8080/foodfusion/public/recipeDetails?id=" . $recipe['id']; 
            $recipeTitle = $recipe['title'] ?? 'Check this recipe!';
        ?>
        <div class="my-8 text-center">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">🔗 Share this recipe</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($recipeUrl) ?>" target="_blank"
                    class="bg-blue-600 hover:bg-blue-100 text-white hover:text-blue-600 px-5 py-2 rounded-full shadow transition duration-300">
                    Share on Facebook
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($recipeUrl) ?>&text=<?= urlencode($recipeTitle) ?>"
                    target="_blank"
                    class="bg-sky-500 hover:bg-sky-100 text-white hover:text-sky-500 px-5 py-2 rounded-full shadow transition duration-300">
                    Share on Twitter
                </a>
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text=<?= urlencode($recipeTitle . ' ' . $recipeUrl) ?>"
                    target="_blank"
                    class="bg-green-500 hover:bg-green-100 text-white hover:text-green-500 px-5 py-2 rounded-full shadow transition duration-300">
                    Share on WhatsApp
                </a>
                <!-- Copy Link -->
                <button onclick="copyLink('<?= $recipeUrl ?>')"
                    class="bg-gray-700 hover:bg-gray-100 cursor-pointer text-white hover:text-gray-700 px-5 py-2 rounded-full shadow transition duration-300">
                    Copy Link
                </button>
            </div>
        </div>

        <div
            class="max-w-4xl mx-auto p-6 mb-5 bg-white/80 backdrop-blur-md rounded-3xl shadow-inner border border-green-100">
            <h3 class="text-2xl font-semibold text-green-700 mb-4">💬 Leave a Comment</h3>
            <form method="POST" action="/foodfusion/public/submitComment" class="space-y-5">
                <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Comment</label>
                    <?php if (!empty($errors['comment'])): ?>
                    <div class=" text-red-500 text-sm py-1 ">
                        <?= htmlspecialchars($errors['comment']) ?>
                    </div>
                    <?php endif; ?>
                    <textarea id="comment" name="comment" rows="4" placeholder="Share your thoughts..."
                        class="w-full resize-none px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400"><?= !empty($errors['comment']) ? '' : htmlspecialchars($old['comment'] ?? '') ?>
                    </textarea>
                </div>

                <button type="submit" id="comment-submit" class=" px-6 py-3 bg-green-500 text-white rounded-xl
                 hover:bg-green-100 cursor-pointer hover:text-green-500 transition-all shadow-md duration-300">
                    ✨ Post Comment
                </button>
            </form>

        </div>
        <!-- 💬 Recent Comments -->
        <div class="max-w-4xl mx-auto">
            <h3 class="text-lg font-semibold text-gray-800 border-b border-green-500  ">Recent Comments</h3>
            <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
            <div class="shadow-sm rounded-2xl p-5 mt-3 flex flex-col justify-start shadow-green-500/50 ">
                <p class="text-gray-700 italic font-semibold ">"<?= htmlspecialchars($comment['comment']) ?>"</p>
                <div class="flex items-center"> <img
                        src="/foodfusion/public/<?= htmlspecialchars($comment['profile_image'] ?? 'default.png') ?>"
                        class="w-10 h-10 mt-4 rounded-full mr-2 object-cover" alt="commenter">
                    <p class="text-sm text-gray-500 mt-1">
                        <?= htmlspecialchars($comment['username'] ?? 'Anonymous') ?>,
                        <?= date('F j, Y', strtotime($comment['created_at'])) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-500">No comments yet.</p>
            <?php endif; ?>
        </div>
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
    <?php include_once __DIR__ . '/../partials/footer.php'; ?>

    <script>
    let wakeLock = null;
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    async function toggleCookMode() {
        const checkbox = document.getElementById('cook-mode');

        if ('wakeLock' in navigator) {
            if (checkbox.checked) {
                try {
                    wakeLock = await navigator.wakeLock.request('screen');
                    console.log('Wake lock is active');

                    // Optional: Re-request wake lock if it's released due to visibility change
                    document.addEventListener('visibilitychange', async () => {
                        if (document.visibilityState === 'visible' && checkbox.checked) {
                            try {
                                wakeLock = await navigator.wakeLock.request('screen');
                                console.log('Wake lock re-acquired after visibility change');
                            } catch (err) {
                                console.error('Wake Lock error on visibility change:', err);
                            }
                        }
                    });
                } catch (err) {
                    console.error('Wake Lock error:', err);
                }
            } else {
                if (wakeLock) {
                    try {
                        await wakeLock.release();
                        wakeLock = null;
                        console.log('Wake lock released');
                    } catch (err) {
                        console.error('Error releasing wake lock:', err);
                    }
                }
            }
        } else {
            alert('Cook Mode is not supported on this browser.');
        }
    }

    document.querySelectorAll("input[type='checkbox']").forEach(cb => {
        cb.addEventListener("change", () => {
            const label = cb.nextElementSibling;
            if (cb.checked) {
                label.classList.add("line-through", "text-gray-400");
            } else {
                label.classList.remove("line-through", "text-gray-400");
            }
        });
    });
    let timerInterval;
    let isRunning = false;
    const timeLeft = <?= intval($recipe['cooking_time']) ?> * 60; // convert min to sec
    let currentTime = timeLeft;

    function updateTimerDisplay() {
        const minutes = String(Math.floor(currentTime / 60)).padStart(2, '0');
        const seconds = String(currentTime % 60).padStart(2, '0');
        document.getElementById('timerDisplay').textContent = `${minutes}:${seconds}`;
    }

    function toggleTimer() {
        const btn = document.getElementById('startPauseBtn');
        if (!isRunning) {
            timerInterval = setInterval(() => {
                if (currentTime > 0) {
                    currentTime--;
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    alert("⏰ Time’s up! Your dish should be ready!");
                    isRunning = false;
                    btn.textContent = "Start";
                }
            }, 1000);
            isRunning = true;
            btn.textContent = "Pause";
        } else {
            clearInterval(timerInterval);
            isRunning = false;
            btn.textContent = "Start";
        }
    }

    function resetTimer() {
        clearInterval(timerInterval);
        currentTime = timeLeft;
        updateTimerDisplay();
        isRunning = false;
        document.getElementById('startPauseBtn').textContent = "Start";
    }

    // Initialize on page load
    document.addEventListener("DOMContentLoaded", updateTimerDisplay);

    function printDiv(divId) {
        const content = document.getElementById(divId).innerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
    <html>
      <head>
        <title>Print Recipe</title>
        <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
        <style>
          body { font-family: 'Poppins', sans-serif; padding: 20px; }
        </style>
      </head>
      <body onload="window.print(); window.close();">
        ${content}
      </body>
    </html>
  `);
        printWindow.document.close();
    }

    document.addEventListener("DOMContentLoaded", () => {
        // LIKE button
        const likeBtn = document.getElementById('like-btn');
        if (likeBtn) {
            likeBtn.addEventListener('click', () => {
                if (!isLoggedIn) {
                    showLoginModal();
                    return;
                }

                const recipeId = likeBtn.dataset.recipeId;

                fetch('/foodfusion/public/recipelikeToggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'recipe_id=' + encodeURIComponent(recipeId),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('like-count').innerText =
                                `${data.like_count} likes`;
                            document.getElementById('like-text').innerText = data.liked ? 'Liked' :
                                'Like';
                        }
                    });
            });
        }

        // FAV button
        const favBtn = document.getElementById('fav-btn');
        if (favBtn) {
            favBtn.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default form submission if inside a form

                if (!isLoggedIn) {
                    showLoginModal();
                    return;
                }

                const recipeId = favBtn.dataset.recipeId;

                fetch('/foodfusion/public/favToggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'recipe_id=' + encodeURIComponent(recipeId),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('fav-count').innerText =
                                `${data.fav_count} favourites`;
                            document.getElementById('fav-text').innerText = data.faved ?
                                '❤️ Saved to Favorites' : '❤️ Save to Favorites';
                        }
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const commentForm = document.querySelector("form[action='/foodfusion/public/submitComment']");

        if (commentForm) {
            commentForm.addEventListener('submit', function(e) {
                if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
                    e.preventDefault(); // stop form submission
                    showLoginModal(); // show popup
                }
            });
        }
    });


    // Show login popup
    function showLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
    }

    // Hide login popup
    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }

    function copyLink(link) {
        navigator.clipboard.writeText(link)
            .then(() => alert("🔗 Link copied to clipboard!"))
            .catch(err => alert("❌ Failed to copy link."));
    }
    </script>
</body>

</html>
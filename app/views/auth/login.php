<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['error'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Foodfusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:wght@100;400;600;700;900&display=swap"
        rel="stylesheet" />
</head>

<body class="min-h-screen bg-gray-50 text-gray-800 font-[poppins]0">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <form action="/foodfusion/public/login" method="POST" class="p-6 rounded-xl shadow-xl w-full max-w-md bg-white">
            <div class="flex flex-col items-center mb-6">
                <img class="w-60 mb-5 rounded-xl"
                    src="http://localhost:8080/foodfusion/public/images/—Pngtree—cute chef cartoon holding plates_13062753.png"
                    alt="Chef Image" />
                <h1 class="text-2xl font-bold text-[#111827] mb-2">Welcome Back</h1>

                <?php if (!empty($errors['login'])): ?>
                <div class="text-red-500 text-sm py-1">
                    <?= htmlspecialchars($errors['login']) ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Username or Email -->
            <div class="mb-4">
                <label for="identifier" class="block text-sm font-medium text-[#111827]">Username / Email</label>
                <?php if (!empty($errors['identifier'])): ?>
                <div class="text-red-500 text-sm py-1">
                    <?= htmlspecialchars($errors['identifier']) ?>
                </div>
                <?php endif; ?>
                <input type="text" name="identifier" id="identifier" placeholder="Enter your username or email"
                    class="w-full p-2 pl-3 rounded-md outline-1 outline-[#16a34a] focus:outline-2 focus:outline-[#bef264]"
                    value="<?= empty($errors['identifier']) ? htmlspecialchars($old['identifier'] ?? '') : '' ?>" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-[#111827]">Password</label>
                <?php if (!empty($errors['password'])): ?>
                <div class="text-red-500 text-sm py-1">
                    <?= htmlspecialchars($errors['password']) ?>
                </div>
                <?php endif; ?>
                <input type="password" name="password" id="password" placeholder="Enter your password"
                    class="w-full p-2 pl-3 rounded-md outline-1 outline-[#16a34a] focus:outline-2 focus:outline-[#bef264]" />
            </div>

            <!-- reCAPTCHA -->
            <?php if (!empty($errors['recaptcha'])): ?>
            <div class="text-red-500 text-sm py-1">
                <?= htmlspecialchars($errors['recaptcha']) ?>
            </div>
            <?php endif; ?>
            <div class="flex justify-center my-5">
                <div class="g-recaptcha" data-sitekey="6LeiYnMrAAAAAA9Oo2BycrHlWe2_m0lE633CjynI"></div>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-full hover:bg-green-100 hover:text-green-600 shadow-md transition duration-300">
                Log in
            </button>

            <p class="mt-4 text-center text-sm text-[#111827]">
                Don’t have an account?
                <a href="register" class="text-[#16a34a] hover:underline">Register</a>
            </p>
        </form>
    </div>
    <?php include_once __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
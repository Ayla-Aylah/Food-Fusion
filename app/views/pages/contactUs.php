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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body class="min-h-screen bg-gray-50 text-gray-800 font-[poppins]">
    <?php include_once __DIR__.'/../partials/header.php';?>
    <main class="max-w-3xl w-full bg-white rounded-3xl shadow-xl p-10 sm:p-14 mx-auto mt-16 mb-12">
        <h1 class="text-4xl font-bold text-center text-green-800 mb-4">📬 Contact Us</h1>
        <p class="text-lg text-center text-green-600 mb-8">
            Have a question, a recipe request, or feedback? Fill out the form below — we’d love to hear from you!
        </p>

        <form action="contactUs" method="POST" class="space-y-6" novalidate>
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-green-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="<?= empty($errors['full_name']) ? htmlspecialchars($old['full_name'] ?? '') : '' ?>"
                    required />
                <?php if (!empty($errors['full_name'])): ?>
                <p class="text-sm text-red-500 mt-1"><?= htmlspecialchars($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-green-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="<?= empty($errors['email']) ? htmlspecialchars($old['email'] ?? '') : '' ?>" required />
                <?php if (!empty($errors['email'])): ?>
                <p class="text-sm text-red-500 mt-1"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Message Type -->
            <div>
                <label for="messageType" class="block text-sm font-medium text-green-700 mb-1">Message Type</label>
                <select id="messageType" name="messageType"
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
                    <option disabled value="">-- Select Type --</option>
                    <option value="enquiry" <?= ($old['messageType'] ?? '') === 'enquiry' ? 'selected' : '' ?>>Enquiry
                    </option>
                    <option value="recipe_request"
                        <?= ($old['messageType'] ?? '') === 'recipe_request' ? 'selected' : '' ?>>Recipe Request
                    </option>
                    <option value="feedback" <?= ($old['messageType'] ?? '') === 'feedback' ? 'selected' : '' ?>>
                        Feedback</option>
                </select>
                <?php if (!empty($errors['messageType'])): ?>
                <p class="text-sm text-red-500 mt-1"><?= htmlspecialchars($errors['messageType']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-green-700 mb-1">Your Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..."
                    class="w-full rounded-xl border border-green-300 px-4 py-3 text-green-900 placeholder:text-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                    required><?= !empty($errors['message']) ? '' : htmlspecialchars($old['message'] ?? '') ?></textarea>
                <?php if (!empty($errors['message'])): ?>
                <p class="text-sm text-red-500 mt-1"><?= htmlspecialchars($errors['message']) ?></p>
                <?php endif; ?>
            </div>
            <?php if (!empty($errors['recaptcha'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['recaptcha']) ?>
            </div>
            <?php endif; ?>
            <div class="flex justify-center items-center flex-col my-5">
                <div class="g-recaptcha" data-sitekey="6LeiYnMrAAAAAA9Oo2BycrHlWe2_m0lE633CjynI" class="my-5"></div>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-100 text-white hover:text-green-600 font-semibold py-3 rounded-xl shadow-lg transition-all duration-300 cursor-pointer">
                ✉️ Send Message
            </button>
        </form>

        <!-- Contact Info -->
        <section class="mt-10 text-center text-green-700">
            <p class="mb-1">Prefer to reach us directly?</p>
            <p>Email: <a href="mailto:support@foodfusion.com"
                    class="underline font-medium text-green-800">support@foodfusion.com</a></p>
            <p class="mt-1">Phone: <a href="tel:+1234567890" class="underline font-medium text-green-800">+1 (234)
                    567-890</a></p>
        </section>
    </main>

    <?php include_once __DIR__.'/../partials/footer.php';?>

</body>

</html>
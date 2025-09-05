<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-50 font-[poppins] text-gray-800">

    <?php include_once __DIR__ . '/../../views/partials/header.php'; ?>

    <div class="max-w-6xl mx-auto p-5">
        <h1 class="text-2xl font-semibold mb-6">Contact Messages</h1>

        <?php if (empty($messages)) : ?>
        <p class="text-gray-600">No messages found.</p>
        <?php else : ?>
        <div class="space-y-6">
            <?php foreach ($messages as $msg) : ?>
            <div class="bg-white p-5 rounded-xl shadow flex flex-col space-y-2 border border-green-200">
                <div><span class="font-semibold">Full Name:</span> <?= htmlspecialchars($msg['full_name']) ?></div>
                <div><span class="font-semibold">Email Address:</span> <?= htmlspecialchars($msg['email']) ?></div>
                <div><span class="font-semibold">Message Type:</span> <?= htmlspecialchars($msg['subject']) ?>
                </div>
                <div>
                    <span class="font-semibold">Message:</span>
                    <p class="mt-1 text-gray-700"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
<?php
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
    <title>Culinary Tips | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php include_once __DIR__ . '/../partials/header.php'; ?>

    <section class="m-10">
        <h1 class="text-3xl font-bold mb-6 text-green-600">Culinary Tips</h1>
        <div class="container mb-5 mx-auto px-8 z-10 overflow-x-auto
        [&::-webkit-scrollbar]:h-2
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">

            <?php if (!empty($tips)) : ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Image</th>
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Description</th>
                        <th class="p-3 border">Posted By</th>
                        <th class="p-3 border">Created At</th>
                        <th class="p-3 border">Is Approved</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tips as $index => $tip): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 border"><?= $index + 1 ?></td>
                        <td class="p-3 border text-center">
                            <?php if (!empty($tip['image_path'])): ?>
                            <img src="/foodfusion/public/<?= htmlspecialchars($tip['image_path']) ?>"
                                class="w-20 h-20 object-cover rounded-xl mx-auto">
                            <?php else: ?>
                            <div
                                class="w-20 h-20 rounded-xl bg-gray-200 flex items-center justify-center text-gray-500 mx-auto">
                                ❌
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3 border"><?= htmlspecialchars($tip['tip_title']) ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($tip['tip_description'] ?? '-') ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($tip['postedby'] ?? '-') ?></td>
                        <td class="p-3 border"><?= date('M j, Y', strtotime($tip['createdat'])) ?></td>
                        <td class="p-3 border text-center">
                            <form method="POST" action="/foodfusion/admin/tiptoggleApproved" class="inline">
                                <input type="hidden" name="tip_id" value="<?= $tip['id'] ?>">
                                <input type="hidden" name="is_approved" value="<?= $tip['is_approved'] ? '0' : '1' ?>">

                                <button type="submit" class="px-3 py-2 rounded-md shadow-md transition-all duration-300 cursor-pointer <?= $tip['is_approved'] ? 'bg-green-500 text-white hover:bg-green-100 hover:text-green-600' : 'bg-red-500 text-white hover:bg-red-100 hover:text-red-600' ?>"
                                    title="<?= $tip['is_approved'] ? 'Disapprove this tip' : 'Approve this tip' ?>"
                                    onclick="return confirm('Are you sure you want to <?= $tip['is_approved'] ? 'disapprove' : 'approve' ?> this tip?');">
                                    <?= $tip['is_approved'] ? '✅ Approved' : '❌ Not Approved' ?>
                                </button>
                            </form>
                        </td>

                        <td class="p-3 border">
                            <form action="/foodfusion/admin/deleteTip" method="POST">
                                <input type="hidden" name="id" value="<?= $tip['id'] ?>">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this tip?')"
                                    class="bg-red-500 text-white hover:bg-red-100 hover:text-red-500 rounded-md transition-all duration-300 shadow-md cursor-pointer p-2">Delete</button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-gray-600">No tips found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
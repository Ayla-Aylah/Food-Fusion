<?php
if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User List | FoodFusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body class="text-gray-800 font-[poppins]">

    <?php include_once __DIR__.'/../partials/header.php'; ?>

    <section class=" m-10">
        <h1 class="text-3xl font-bold mb-6 text-green-600"> User List</h1>
        <div class="container mb-5 mx-auto px-8 z-10 overflow-y-auto
  [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">

            <?php if (!empty($users)) : ?>
            <table class="w-full  ">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="p-3 border">id</th>
                        <th class="p-3 border">Profile</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Username</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Registered At</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $index => $user): ?>
                    <tr class="border-t">
                        <td class="p-3 border"><?= $index + 1 ?></td>
                        <td class="p-3 border"> <?php if (!empty($user['profile_image'])): ?>
                            <img src="/foodfusion/public/<?= htmlspecialchars($user['profile_image']) ?>"
                                alt="Profile Image" class="w-20 h-20 rounded-full object-cover">
                            <?php else: ?>
                            <div
                                class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <img src="/foodfusion/public/uploads/profile/defaultprofile.jpg" alt="">
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3 border"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                        </td>
                        <td class="p-3 border"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($user['created_at']) ?></td>
                        <td class="p-3 border">
                            <form action="deleteUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="btn btn-danger bg-red-500 px-3 py-2 text-white rounded-md hover:bg-red-100 hover:text-red-500 shadow-md  transition duration-300">Delete</button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No users found.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php include_once __DIR__.'/../partials/footer.php'; ?>

</body>

</html>
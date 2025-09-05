<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin'])) {
    header('Location: /foodfusion/admin/adminLogin');
    exit;
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
    <title>Post Cooking Tutorial | Food Fusion</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="text-gray-800 font-[poppins]">
    <?php 
     include_once __DIR__ . '/../../views/partials/header.php'; ?>
    <section class="m-10">
        <div class="flex items-center justify-between ">
            <h1 class="text-3xl font-bold mb-6 text-green-600">Team List</h1>
            <a href="/foodfusion/admin/createTeamMember"
                class=" px-3 py-2 mr-10 transition-all duration-300 shadow-md text-white rounded-lg bg-green-600 hover:bg-green-100 hover:text-green-600">+
                Post
                new Member</a>
        </div>
        <div class="container mb-5 mx-auto px-8 z-10 overflow-y-auto
  [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-4 py-3 border">#</th>
                        <th class="px-4 py-3 border">Photo</th>
                        <th class="px-4 py-3 border">Name</th>
                        <th class="px-4 py-3 border">Position</th>
                        <th class="px-4 py-3 border">Email</th>
                        <th class="px-4 py-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($members as $member): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 border"><?= $i++ ?></td>
                        <td class="px-4 py-3 border">
                            <img src="http://localhost:8080/foodfusion/public/<?= htmlspecialchars($member['photo']) ?>"
                                alt="Profile" class="w-12 h-12 rounded-full object-cover">
                        </td>
                        <td class="px-4 py-3 border font-medium text-gray-800"><?= htmlspecialchars($member['name']) ?>
                        </td>
                        <td class="px-4 py-3 border text-gray-600"><?= htmlspecialchars($member['position']) ?></td>
                        <td class="px-4 py-3 border text-gray-600"><?= htmlspecialchars($member['email']) ?></td>
                        <td class="px-4 py-3 border space-x-2">
                            <a href="/foodfusion/admin/editTeamMember?id=<?= $member['id'] ?>"
                                class="text-green-600 hover:underline">Edit</a>

                            <form action="deleteMember" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $member['id'] ?>">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="btn btn-danger bg-red-500 px-3 py-2 text-white rounded-md hover:bg-red-100 hover:text-red-500 shadow-md  transition duration-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include_once __DIR__ . '/../../views/partials/footer.php'; ?>

</body>

</html>
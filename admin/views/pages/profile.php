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
    <title>Profile</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md text-gray-800">
        <h2 class="text-2xl font-bold text-green-600 mb-4">My Profile</h2>

        <div class="flex">
            <div class="mx-5">
                <?php if (!empty($admin['profile_image'])): ?>
                <img src="/foodfusion/public/<?= htmlspecialchars($admin['profile_image']) ?>" alt="Profile Image"
                    class="w-24 h-24 rounded-full object-cover">
                <?php else: ?>
                <div class="w-24 h-24 rounded-full  flex items-center justify-center">
                    <img src="/foodfusion/public/uploads/profile/defaultprofile.jpg" alt="">
                </div>
                <?php endif; ?>
            </div>

            <div class="space-y-2">
                <p class="font-semibold text-2xl">
                    <?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></p>
                <p>@<?= htmlspecialchars($admin['username']) ?></p>
                <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($admin['created_at'])) ?></p>
            </div>
        </div>

        <div class="mt-5 ">
            <div class="rounded-md shadow-sm p-3" mt-6>
                <h1 class="mb-2">Profile Preferences</h1>
                <button onclick="openEditProfile()"
                    class="bg-green-600 transition duration-300  text-white font-semibold px-6 py-2 rounded hover:bg-green-700 ">
                    Edit Profile
                </button>
            </div>
            <div class="mt-4 rounded-md shadow-sm  p-3">
                <h1 class="mb-2">Account Settings</h1>
                <a class="bg-green-600  transition duration-300 hover:bg-green-700 text-white font-semibold px-6 rounded py-2"
                    href="logout">Logout </a>
            </div>
            <div class="mt-4 p-3 rounded-md shadow-sm">
                <h1 class="mb-2">Danger Zone</h1>
                <form action="/foodfusion/admin/deleteAccount" method="POST" style="display:inline;">
                    <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')"
                        class="btn btn-danger bg-red-500 px-3 py-2 text-white rounded-md hover:bg-red-100 hover:text-red-500 shadow-md  transition duration-300">Delete</button>
                </form>
            </div>
            <!-- Edit Profile Pop Up Form Modal -->
            <div id="editProfile"
                class="backdrop-blur-xs bg-black/20 fixed inset-0 z-50 hidden bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg relative max-h-[90vh] overflow-y-auto p-6">

                    <!-- Close Button -->
                    <button onclick="closeEditProfile()"
                        class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                        aria-label="Close">
                        &times;
                    </button>

                    <!-- Edit Profile Pop Up Form -->
                    <h2 class="text-2xl font-bold mb-4 text-center text-green-600">Edit your Profile</h2>

                    <form action="/foodfusion/admin/profile" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        <div class="flex flex-row items-center justify-center">
                            <!--  profile image preview -->
                            <?php if (!empty($admin['profile_image'])): ?>
                            <img class="w-24 h-24 object-cover rounded-full" id="profilePreview"
                                src="/foodfusion/public/<?php echo $admin['profile_image']; ?>" alt="Profile Image"
                                style="border-radius: 8px;">
                            <?php else: ?>
                            <img class="w-24 h-24 object-cover rounded-full" id="profilePreview"
                                src="/foodfusion/public/uploads/profile/defaultprofile.jpg" alt="Default Profile"
                                width="150">
                            <?php endif; ?>
                            <div class="flex flex-col">
                                <input type="file" name="profile_image" id="profile_image" class="hidden">
                                <!-- Custom upload button -->
                                <label for="profile_image"
                                    class="inline-block bg-green-600 mx-10 mb-5 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-green-100 hover:text-green-600 shadow-md duration-300 transition">
                                    Upload Profile Photo
                                </label>
                                <button
                                    class="bg-red-500 transition duration-300 rounded-md px-3 py-2 hover:bg-red-100 hover:text-red-500 text-white shadow-md mx-10">Delete
                                    Profile Photo</button>
                            </div>

                        </div>

                        <div>
                            <?php if (!empty($errors['profile_image'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($errors['profile_image']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div> <?php if (!empty($errors['first_name'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($errors['first_name']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="first_name" placeholder="First Name"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= htmlspecialchars($old['first_name'] ?? $admin['first_name']) ?>" />
                        </div>
                        <div>
                            <?php if (!empty($errors['last_name'])): ?>
                            <div class=" text-red-500 text-sm text-left">
                                <?= htmlspecialchars($errors['last_name']) ?>
                            </div>
                            <?php endif; ?><input type="text" name="last_name" placeholder="Last Name"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= htmlspecialchars($old['last_name'] ?? $admin['last_name']) ?>" />
                        </div>
                        <div>
                            <?php if (!empty($errors['username'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($errors['username']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="username" placeholder="Username"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2"
                                value="<?= htmlspecialchars($old['username'] ?? $admin['username']) ?>" />
                        </div>

                        <div><?php if (!empty($errors['email'])): ?>
                            <div class="text-left text-red-500 text-sm ">
                                <?= htmlspecialchars($errors['email']) ?>
                            </div>
                            <?php endif; ?>
                            <input type="text" name="email" placeholder="Email"
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                                value="<?= htmlspecialchars($old['email'] ?? $admin['email']) ?>" />
                        </div>


                        <input type="hidden" name="form_type" value="register">
                        <button type="submit"
                            class="w-full bg-green-600 text-white font-semibold py-2 rounded hover:bg-green-700 transition">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Pop Up AutoLoad when there are data validation errors -->
        <?php if (!empty($errors)): ?>
        <script>
        window.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editProfile');
            if (modal) modal.classList.remove('hidden');
        });
        </script>
        <?php endif; ?>
    </div>
    </div>

    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <script>
    // Edit Profile Model
    const modal = document.getElementById('editProfile');

    function openEditProfile() {
        modal.classList.remove('hidden');
    }

    function closeEditProfile() {
        modal.classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeEditProfile();
        }
    });


    document.getElementById('profile_image').addEventListener('change', function(e) {
        const preview = document.getElementById('profilePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>
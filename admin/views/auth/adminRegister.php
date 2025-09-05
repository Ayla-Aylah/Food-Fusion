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
    <title>Register</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <div class=" font-[poppins]  min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 ">
        <form action="adminRegister" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full max-w-md">
            <div class="container mx-auto p-4">
                <h1 class="text-center text-2xl  text-[#111827]  font-bold mb-4">Create Admin Account</h1>
                <?php if (!empty($errors['registerFailed'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['registerFailed']) ?>
                </div>
                <?php endif;?>

            </div>


            <div class="mb-4">
                <label for="first_name" class="block text-sm text-[#111827] font-medium">First Name</label>
                <?php if (!empty($errors['first_name'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['first_name']) ?>
                </div>
                <?php endif; ?>
                <input type="text" name="first_name" id="first_name" placeholder="Enter your first name"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                    value="<?= empty($errors['first_name'])?htmlspecialchars($old['first_name']?? ''):''?>">
            </div>
            <div class=" mb-4">
                <label for="last_name" class="block text-sm text-[#111827] font-medium">Last Name</label>
                <?php if (!empty($errors['last_name'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['last_name']) ?>
                </div>
                <?php endif; ?>
                <input type="text" name="last_name" id="last_name" placeholder="Enter your last name"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                    value="<?= empty($errors['last_name'])?htmlspecialchars($old['last_name']?? ''):''?>">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm text-[#111827] font-medium">Username</label>
                <?php if (!empty($errors['username'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['username']) ?>
                </div>
                <?php endif; ?>
                <input type="text" name="username" id="username" placeholder="Enter your username"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                    value="<?= empty($errors['username'])?htmlspecialchars($old['username']?? ''):''?>">
            </div>
            <div class="mb-4 mt-4">


                <label for="email" class="block text-sm text-[#111827] font-medium">Email</label>
                <?php if (!empty($errors['email'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['email']) ?>
                </div>
                <?php endif; ?>
                <input name="email" id="email" placeholder="Enter your email address"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                    value="<?= empty($errors['email'])?htmlspecialchars($old['email']?? ''):''?>">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm text-[#111827] font-medium">Password</label>
                <?php if (!empty($errors['password'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['password']) ?>
                </div>
                <?php endif; ?>
                <input type="password" name="password" id="password" placeholder="Enter password"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                    value="<?= empty($errors['password'])?htmlspecialchars($old['password']?? ''):''?>">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm text-[#111827] font-medium">Confirm
                    Password</label>
                <?php if (!empty($errors['confirm_password'])): ?>
                <div class=" text-red-500 text-sm py-1 ">
                    <?= htmlspecialchars($errors['confirm_password']) ?>
                </div>
                <?php endif; ?>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password"
                    class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2">
            </div>
            <?php if (!empty($errors['terms'])): ?>
            <div class=" text-red-500 text-sm py-1 ">
                <?= htmlspecialchars($errors['terms']) ?>
            </div>
            <?php endif; ?>
            <div class="flex items-center mb-4">
                <label class="flex items center mb-4"></label>
                <input type="checkbox" name="terms" id="terms"
                    class="mr-2 rounded-md bg-white   accent-green-600 focus-within:outline-[#bef264]">
                <span class="text-sm text-[#111827]">I agree to the <a href="terms"
                        class="text-[#16a34a] hover:underline">terms and
                        conditions</a></span>
                </label>
            </div>
            <input type="hidden" name="form_type" value="register">

            <button type="submit"
                class="w-full bg-[#16a34a] text-white font-semibold py-2 px-4 rounded-md hover:bg-green-700 transition duration-300">Register</button>
            <p class="mt-4 text-center text-sm text-[#111827]">Already have an account? <a href="adminLogin"
                    class="text-[#16a34a] hover:underline">Login</a></p>
        </form>
    </div>
    </div>

    </div>

    </form>
    </div>



    <?php include_once __DIR__.'/../partials/footer.php'; ?>
</body>

</html>
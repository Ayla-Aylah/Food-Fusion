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
    <title>Login</title>
    <link href="http://localhost:8080/foodfusion/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Matemasie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php include_once __DIR__.'/../partials/header.php'; ?>
    <div class=" font-[poppins] min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8  ">
        <form action="adminLogin" method="POST" class=" p-6 rounded-xl shadow-md w-full max-w-md flex">
            <div class="container mx-auto p-4">
                <div class="flex justify-center items-center flex-col">

                    <h1 class="text-center text-2xl  text-[#111827] font-bold mb-4">Admin Login Form</h1>
                    <?php if (!empty($errors['login'])): ?>
                    <div class=" text-red-500 text-sm py-1" <?= htmlspecialchars($errors['login']) ?>>
                    </div>
                    <?php endif; ?>
                </div>



                <div class=" mb-4">
                    <label for="identifier" class="block text-sm text-[#111827] font-medium">Username /
                        Email</label>
                    <?php if (!empty($errors['identifier'])): ?>
                    <div class=" text-red-500 text-sm py-1 ">
                        <?= htmlspecialchars($errors['identifier']) ?>
                    </div>
                    <?php endif; ?>

                    <input type="text" name="identifier" id="identifier"
                        placeholder="Enter your username or email address"
                        class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 "
                        value="<?= empty($errors['identifier'])?htmlspecialchars($old['identifier']?? ''):''?>">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm text-[#111827] font-medium">Password</label>
                    <?php if (!empty($errors['password'])): ?>
                    <div class=" text-red-500 text-sm py-1 ">
                        <?= htmlspecialchars($errors['password']) ?>
                    </div>
                    <?php endif; ?>
                    <input type="password" name="password" id="password" placeholder="Enter your password"
                        class=" flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-[#16a34a] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#bef264] w-full p-2 ">
                </div>

                <button type="submit"
                    class="w-full bg-[#16a34a] text-white font-semibold py-2 px-4 rounded-md hover:bg-green-700 transition duration-300">Log
                    in
                </button>
                <p class="mt-4 text-center text-sm text-[#111827]">Already have an account? <a href="adminRegister"
                        class="text-[#16a34a] hover:underline">Register</a></p>


            </div>
    </div>

    </div>

    </form>
    </div>



    <?php include_once __DIR__.'/../partials/footer.php'; ?>
</body>

</html>
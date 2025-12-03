<?php
// start session as early as possible (no output should appear before this)
require_once '../includes/session_config.inc.php';

if (!empty($_SESSION['signup_errors'])) {
    echo '<div class="text-red-600 mb-3">';
    foreach ($_SESSION['signup_errors'] as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '</div>';
    unset($_SESSION['signup_errors']);
}

if (!empty($_SESSION['signup_success'])) {
    echo '<div class="text-green-600 mb-3">' . htmlspecialchars($_SESSION['signup_success']) . '</div>';
    unset($_SESSION['signup_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <form action="./backend-config-file/signup.inc.php" method="post" class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-2xl font-semibold mb-4">Create Admin Account</h2>

            

            <label class="block mb-2 text-sm">Email</label>
            <input type="email" name="email" required class="w-full mb-4 px-3 py-2 border rounded" />

            <label class="block mb-2 text-sm">Password</label>
            <input type="password" name="password" required class="w-full mb-4 px-3 py-2 border rounded" />

            <label class="block mb-2 text-sm">Confirm Password</label>
            <input type="password" name="confirm_password" required class="w-full mb-4 px-3 py-2 border rounded" />

            <button type="submit" class="w-full bg-[#1E9E9E] text-white py-2 rounded">Create Account</button>

            <p class="text-sm text-center mt-4">Already have an account? <a href="./login.php" class="text-teal-600">Login</a></p>
        </form>
    </div>
</body>
</html>

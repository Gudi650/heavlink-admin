<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';

//include the user.inc.php file to fetch user data
require_once __DIR__ . '/backend-config-file/user.inc.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<?php
    $mainContentFile = "./main-content-files/main-content-user.php";
    include "templates/sidenav.php";
?>


</body>
</html>
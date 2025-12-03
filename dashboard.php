<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

    <?php
    $mainContentFile = "./main-content-files/main-content-index.php";
    include "templates/sidenav.php";
    ?>

    
</body>
</html>

<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Demo Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body { font-family: 'Noto Sans', sans-serif; }
    .font-noto-regular { font-family: 'Noto Sans', sans-serif; }
  </style>
</head>
<body class="bg-gray-50">
  
  <?php

    $mainContentFile = "./main-content-files/main-content-demo.php";
    include "templates/sidenav.php";

  ?>


</body>
</html>

<?php
// Require auth before rendering
include_once __DIR__ . '/includes/auth.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<?php
    $mainContentFile = "./main-content-files/main-content-settings.php";
    include "templates/sidenav.php";
?>

</body>
</html>

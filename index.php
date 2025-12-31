<?php
// Include connection details from outside the project
require_once '/home/eden/scripts/dnd_tracker_php_conn.php';

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://{$username}:{$password}@{$servername}?authSource=admin");
    
    // Select a database and collection
    $database = $client->selectDatabase($dbname);
    $collection = $database->selectCollection('default');
    
    // echo "Connection to MongoDB successful!";
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Fatal Error: " . $e->getMessage() . PHP_EOL;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DnD Tracker</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom CSS stylesheet -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <div class="container">
        <img src="assets/global/banner.png" height="100px"/>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Custom JavaScript file -->
    <script src="js/main.js"></script>
</body>
</html>
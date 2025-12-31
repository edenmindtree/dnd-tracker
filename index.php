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
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DnD Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Custom CSS stylesheet -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <div class="container">
        <img src="assets/global/banner.png" height="100px"/>
    </div>

    <div class="container">
      <h1>Welcome to Dark Mode</h1>
      <p class="text-body">This text and background will adapt to the dark theme.</p>
    </div>

    <div class="container">
    <div class="row">
        <div class="col">Column</div>
        <div class="col">Column</div>
        <div class="w-100"></div>
        <div class="col">Column</div>
        <div class="col">Column</div>
    </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Custom JavaScript file -->
    <script src="js/main.js"></script>
</body>
</html>
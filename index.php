<?php
// Include connection details from outside the project
require_once '/home/eden/scripts/dnd_tracker_php_conn.php';

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://{$servername} -u {$username} -p '{$password}'");
    
    // Select a database and collection
    $database = $client->selectDatabase($dbname);
    $collection = $database->selectCollection('default');
    
    echo "Connection to MongoDB successful!";
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Fatal Error: " . $e->getMessage() . PHP_EOL;
}


?>
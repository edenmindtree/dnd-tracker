<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $player_name = $data["player_name"];

    try {
        // Include DB connection details from outside the project
        require_once '/home/eden/scripts/dnd_tracker_php_conn.php';

        // Include the Composer autoloader
        require_once __DIR__ . '/vendor/autoload.php';

        // Connect to MongoDB
        $client = new MongoDB\Client("mongodb://{$username}:{$password}@{$servername}?authSource=admin");
        
        // Select a database and collection
        $database = $client->selectDatabase($dbname);
        $collection = $database->selectCollection('player_data');
        
        $collection->deleteMany(['player_name' => $player_name]);
        $result = $collection->insertOne($data);

        echo "Save successful.";
        
    } catch (MongoDB\Driver\Exception\Exception $e) {
        $error_message = "Fatal Database Error: " . $e->getMessage() . PHP_EOL;
        echo $error_message;
        throw new Exception($error_message);
    }
}
?>
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


    <div class="banner container">
        <img src="assets/global/banner.png" height="100px"/>
    </div>

    <div class="container">
    <div class="row">
        <!-- Row 1 -->
        <div class="col">
            <h1>Player: <span id="player-name">Gink</span></h1>
            <img src="assets/characters/gink/gink.png" height="100px"/>
        </div>

        <div class="col"><h1>Level: <span id="total-level"></span></h1></div>

        <div class="col">
            <h1>Class: <span class="add-button" id="open-new-class-popup-btn">+</span></h1>
            <ul id="class-list">
                <li><input type="number" class="class-input" id="class-0" name="class-0" min="0" max="20" step="1" oninput="setTotalLevel()" value="2"> Rogue <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" class="class-input" id="class-1" name="class-1" min="0" max="20" step="1" oninput="setTotalLevel()" value="6"> Ranger <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" class="class-input" id="class-2" name="class-2" min="0" max="20" step="1" oninput="setTotalLevel()" value="2"> Fighter <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
            </ul>
        </div>

        <!-- class popup -->
        <div id="popup-new-class-overlay" class="overlay">
            <div id="popup-new-class-form" class="popup">
                <h2>Add Class</h2>
                <form id="new-class-form">
                    <label for="new-class">Class:</label>
                    <input type="text" id="new-class" name="new-class" required>
                    </br>
                    <label for="new-class-lvl">Level:</label>
                    <input type="number" id="new-class-lvl" name="new-class-lvl" required>
                    </br>
                    <button type="submit">Submit</button>
                </form>
                <button id="close-new-class-popup">Close</button>
            </div>
        </div>



        <div class="w-100"></div>

        <!-- Row 2 -->
        <div class="col">
            <h1>Abilities: <span class="add-button" id="open-new-ability-popup-btn">+</span></h1>
            <ul id="ability-list">
                <li><input type="number" id="ability-0" name="ability-0" min="0" max="999" step="1" value="3"> Luck Points <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="ability-1" name="ability-1" min="0" max="999" step="1" value="3"> Favored Foe <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="ability-2" name="ability-2" min="0" max="999" step="1" value="1"> Second Wind <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="ability-3" name="ability-3" min="0" max="999" step="1" value="1"> Action Surge <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="ability-4" name="ability-4" min="0" max="999" step="1" value="1"> Soul of the Fallen <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="ability-5" name="ability-5" min="0" max="999" step="1" value="1"> Marked by the Shard <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
            </ul>
        </div>

        <!-- ability popup -->
        <div id="popup-new-ability-overlay" class="overlay">
            <div id="popup-new-ability-form" class="popup">
                <h2>Add Ability</h2>
                <form id="new-ability-form">
                    <label for="new-ability">Ability:</label>
                    <input type="text" id="new-ability" name="new-ability" required>
                    </br>
                    <label for="new-ability-quan">Charges:</label>
                    <input type="number" id="new-ability-quan" name="new-ability-quan" required>
                    </br>
                    <button type="submit">Submit</button>
                </form>
                <button id="close-new-ability-popup">Close</button>
            </div>
        </div>


        <div class="col">
            <h1>Items: <span class="add-button" id="open-new-item-popup-btn">+</span></h1>
            <ul id="item-list">
                <li><input type="number" id="item-0" name="item-0" min="0" max="9999" step="1" value="25"> Arrows <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-1" name="item-1" min="0" max="9999" step="1" value="45"> Bolts <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-2" name="item-2" min="0" max="9999" step="1" value="5"> +2 Bolt <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-3" name="item-3" min="0" max="9999" step="1" value="1"> Lvl 1 Cure Wounds <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-4" name="item-4" min="0" max="9999" step="1" value="2"> Healing Potion <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-5" name="item-5" min="0" max="9999" step="1" value="2"> Greater Healing Potion <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="item-6" name="item-6" min="0" max="9999" step="1" value="1"> lvl 6 Spell Slot Potion <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
            </ul>
        </div>

        <!-- item popup -->
        <div id="popup-new-item-overlay" class="overlay">
            <div id="popup-new-item-form" class="popup">
                <h2>Add Item</h2>
                <form id="new-item-form">
                    <label for="new-item">Item:</label>
                    <input type="text" id="new-item" name="new-item" required>
                    </br>
                    <label for="new-item-quan">Quantity:</label>
                    <input type="number" id="new-item-quan" name="new-item-quan" required>
                    </br>
                    <button type="submit">Submit</button>
                </form>
                <button id="close-new-item-popup">Close</button>
            </div>
        </div>

        <div class="col">
            <h1>Spells: <span class="add-button" id="open-new-spell-popup-btn">+</span></h1>
            <ul id="spell-list">
                <li><input type="number" id="spell-0" name="spell-0" min="0" max="20" step="1" value="4"> Level 1 <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
                <li><input type="number" id="spell-1" name="spell-1" min="0" max="20" step="1" value="2"> Level 2 <svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg></li>
            </ul>
        </div>

        <!-- spell popup -->
        <div id="popup-new-spell-overlay" class="overlay">
            <div id="popup-new-spell-form" class="popup">
                <h2>Add spell</h2>
                <form id="new-spell-form">
                    <label for="new-spell">Spell Lvl/Class:</label>
                    <input type="text" id="new-spell" name="new-spell" required>
                    </br>
                    <label for="new-spell-quan">Quantity:</label>
                    <input type="number" id="new-spell-quan" name="new-spell-quan" required>
                    </br>
                    <button type="submit">Submit</button>
                </form>
                <button id="close-new-spell-popup">Close</button>
            </div>
        </div>

    </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Custom JavaScript file -->
    <script src="js/main.js"></script>

    <svg width="0" height="0" style="display: none">
        <svg id="trash-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
        </svg>
    </svg>

</body>
</html>
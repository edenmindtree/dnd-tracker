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
        
        <!-- Player -->
        <div class="col">
            <h1>Player: <span id="player-name">Gink</span></h1>
            <img src="assets/characters/gink/gink.png" height="100px"/>
            <svg class="load-save-icon" id="open-load-popup-btn"><use xlink:href="#load-icon"></use></svg>
            <svg class="load-save-icon" id="open-save-popup-btn"><use xlink:href="#save-icon"></use></svg>
        </div>

        <!-- load popup -->
        <div id="popup-new-load-overlay" class="overlay">
            <div id="popup-new-load-form" class="popup">
                <h2>Load Data</h2>
                <p>This will load the last saved player's state.</p>
                <form id="new-load-form">
                    <button type="submit">Load</button>
                </form>
                <button id="close-new-load-popup">Close</button>
            </div>
        </div>

        <!-- save popup -->
        <div id="popup-new-save-overlay" class="overlay">
            <div id="popup-new-save-form" class="popup">
                <h2>Save Data</h2>
                <p>This will save the current player's state.</p>
                <form id="new-save-form">
                    <button type="submit">Save</button>
                </form>
                <button id="close-new-save-popup">Close</button>
            </div>
        </div>

        <!-- save success toast -->
        <div id="saveSuccessToast" class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
            Data has been successfully saved.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        </div>

        <!-- save error toast -->
        <div id="saveErrorToast" class="toast align-items-center text-bg-danger border-0 position-fixed top-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
            There was an error saving the data.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        </div>

        <!-- Level -->
        <div class="col"><h1>Level: <span id="total-level"></span></h1></div>

        <!-- Classes -->
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
        <!-- Abilities -->
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

        <!-- Items -->
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

        <!-- Spells -->
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

    <!-- Custom JavaScript for in-page actions-->
    <script src="js/main.js"></script>

    <!-- Custom Javascript for loading and saving -->
    <script src="js/load_save.js"></script>

    <svg width="0" height="0" style="display: none">
        <svg id="trash-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
        </svg>

        <svg id="save-icon" xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-floppy" viewBox="0 0 50 50">
        <path d="M11 2H9v3h2z"/>
        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
        </svg>

        <svg id="load-icon" xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-download" viewBox="0 0 50 50">
        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
        </svg>
    </svg>

</body>
</html>
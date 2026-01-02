function buildSaveObject() {
    let saveObject = {
        "player_name": "",
        "level": "",
        "class": [],
        "abilities": [],
        "items": [],
        "spells": [],
        "time_saved": ""
    };
    // Set Name
    saveObject.player_name = document.getElementById("player-name").textContent;
    // Set Level
    saveObject.level = document.getElementById("total-level").textContent;
    // Set class
    saveObject.class = getListData("class-list");
    // Set abilities
    saveObject.abilities = getListData("ability-list");
    // Set items
    saveObject.items = getListData("item-list");
    // Set spells
    saveObject.spells = getListData("spell-list");
    // Set time_saved
    saveObject.time_saved = new Date().toISOString();
    
    return saveObject;
}

function saveTheData() {
    const saveDataObject = buildSaveObject();
    // console.log(saveDataObject);
    return saveDataObject;
}

// SAVE ACTIONS
// Get Constant elements
const saveOpenBtn = document.getElementById("open-save-popup-btn");
const saveCloseBtn = document.getElementById("close-new-save-popup");
const saveOverlay = document.getElementById("popup-new-save-overlay");
const saveForm = document.getElementById('new-save-form');

// Event listeners for button clicks
saveOpenBtn.addEventListener("click", () => {
  openPopup(saveOverlay);
});
saveCloseBtn.addEventListener("click", () => {
  closePopup(saveOverlay);
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === saveOverlay) {
    closePopup(saveOverlay);
  }
});

// Add Submit Save event listener
saveForm.addEventListener('submit', function (event) {
    const dataToSave = saveTheData();

    fetch('save.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        // Convert the save object to a JSON string
        body: JSON.stringify(dataToSave) 
    })
    .then(response => response)
    .then(data => {
        // Handle the response from the PHP page, check if OK (not 500)
        if (!data.ok) {
            return data.text().then(text => {
                throw new Error('PHP Error: ' + text);
            });
        }

        data.text().then(text => {
            console.log('Save response from server: ' + text);
        });
        
        closePopup(saveOverlay);

        const saveSuccessToast = document.getElementById('saveSuccessToast')
        const saveSuccessToastBootstrap = bootstrap.Toast.getOrCreateInstance(saveSuccessToast)
        saveSuccessToastBootstrap.show()
    })
    .catch((error) => {
        console.error('Error:', error);
        closePopup(saveOverlay);

        const saveErrorToast = document.getElementById('saveErrorToast')
        const saveErrorToastBootstrap = bootstrap.Toast.getOrCreateInstance(saveErrorToast)
        saveErrorToastBootstrap.show()
    });
});

// LOAD ACTIONS
// Get Constant elements
const loadOpenBtn = document.getElementById("open-load-popup-btn");
const loadCloseBtn = document.getElementById("close-new-load-popup");
const loadOverlay = document.getElementById("popup-new-load-overlay");
const loadForm = document.getElementById('new-load-form');
const notFoundLoadOpenBtn = document.getElementById("not-found-load-popup-btn");

// Event listeners for button clicks
loadOpenBtn.addEventListener("click", () => {
  openPopup(loadOverlay);
});
loadCloseBtn.addEventListener("click", () => {
  closePopup(loadOverlay);
});
notFoundLoadOpenBtn.addEventListener("click", () => {
  openPopup(loadOverlay);
  console.log("notFoundLoadOpenBtn");
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === loadOverlay) {
    closePopup(loadOverlay);
  }
});

// Add Submit event listeners
loadForm.addEventListener('submit', function (event) {
    // 1. Prevent the form's default submission behavior (prevents the page reload/POST)
    event.preventDefault();
    loadForm.method = 'POST';
    loadForm.action = 'index.php';
    loadForm.submit();
});

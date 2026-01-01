function saveTheData() {
    const saveDataObject = buildSaveObject();
    // console.log(saveDataObject);
    return saveDataObject;
}

// LOAD ACTIONS
// Get Constant elements
const loadOpenBtn = document.getElementById("open-load-popup-btn");
const loadCloseBtn = document.getElementById("close-new-load-popup");
const loadOverlay = document.getElementById("popup-new-load-overlay");
const loadForm = document.getElementById('new-load-form');

// Event listeners for button clicks
loadOpenBtn.addEventListener("click", () => {
  openPopup(loadOverlay);
});
loadCloseBtn.addEventListener("click", () => {
  closePopup(loadOverlay);
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
});

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
    // const dataToSend = {
    //     "save_data": dataToSave
    // }
    console.log(JSON.stringify(dataToSave) );
    
    fetch('save.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        // Convert the save object to a JSON string
        body: JSON.stringify(dataToSave) 
    })
    .then(response => response) // Or .json() if PHP returns JSON
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
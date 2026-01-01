// Global Constants
const trashSvg = '<svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg>'

// Functions
function setTotalLevel() {
    // 1. Select all input elements with the class 'amount'
    const inputs = document.querySelectorAll('input.class-input');
    let total = 0;

    // 2. Iterate through the inputs and sum their values
    inputs.forEach(input => {
        // Convert the string value from the input to a number
        const value = Number(input.value) || 0; 
        total += value;
    });
    // set the total text
    const resultElement = document.getElementById('total-level');
    resultElement.textContent = total;
}

function getHighestListNumber(listQuery) {
    const listItems = document.querySelectorAll(listQuery);
    let currentNumbers = [];
    listItems.forEach(function(element) {
        const allChildren = element.querySelectorAll(':scope > input');
        let num = allChildren[0].id.split("-")[1];
        currentNumbers.push(num)
    });
    const max = Math.max(...currentNumbers);
    return max+1;
}
// Submit New Generic Item
function submitNewItem(itemType, itemMax, overlay) {
  const nameValue = document.getElementById(`new-${itemType}`).value;
  const quanValue = document.getElementById(`new-${itemType}-quan`).value;

  const count = getHighestListNumber(`#${itemType}-list li`)

  addToList(`${itemType}-list`, `<input type="number" class="${itemType}-input" id="${itemType}-${count}" name="${itemType}-${count}" min="0" max="${itemMax}" step="1" value="${quanValue}"> ${nameValue} ${trashSvg}`);
  setTotalLevel();
  closePopup(overlay);
}

// Function to open the popup
function openPopup(overlay) {
  overlay.style.display = "block";
}

// Function to close the popup
function closePopup(overlay) {
  overlay.style.display = "none";
}

function addToList(listName, listItem) {
    const list = document.getElementById(listName);
    const newItem = document.createElement("li");
    newItem.innerHTML = listItem;
    list.appendChild(newItem);
}

function removeItem(listObject) {
  const itemToRemove = listObject.parentElement;
  if(itemToRemove) {
    itemToRemove.remove();
    setTotalLevel();
  }
}

function getListData(listId) {
    let listData = [];
    const listItems = document.querySelectorAll(`#${listId} li`);
    listItems.forEach(function(element) {
        const nameValue = element.textContent.trim();
        const inputValue = element.querySelectorAll(':scope > input')[0].value;
        const elementData = {
            "name": nameValue,
            "quantity": inputValue
        }
        listData.push(elementData);
    });
    return listData
}

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

// Starter function to load with page
setTotalLevel();
console.log(buildSaveObject());

// NEW CLASS
// Get Constant elements
const classOpenBtn = document.getElementById("open-new-class-popup-btn");
const classCloseBtn = document.getElementById("close-new-class-popup");
const classOverlay = document.getElementById("popup-new-class-overlay");
const classForm = document.getElementById('new-class-form');

// Event listeners for button clicks
classOpenBtn.addEventListener("click", () => {
  openPopup(classOverlay);
});
classCloseBtn.addEventListener("click", () => {
  closePopup(classOverlay);
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === classOverlay) {
    closePopup(classOverlay);
  }
});

// Add Submit event listeners
classForm.addEventListener('submit', function (event) {
    // 1. Prevent the form's default submission behavior (prevents the page reload/POST)
    event.preventDefault();
    submitNewClass();
});

// Submit New Class
function submitNewClass() {
  const nameValue = document.getElementById('new-class').value;
  const levelValue = document.getElementById('new-class-lvl').value;

  const count = getHighestListNumber('#class-list li')

  addToList("class-list", `<input type="number" class="class-input" id="class-${count}" name="class-${count}" min="0" max="20" step="1" oninput="setTotalLevel()" value="${levelValue}"> ${nameValue} ${trashSvg}`);
  setTotalLevel();
  closePopup(classOverlay);
}


// NEW ability
// Get Constant elements
const abilityOpenBtn = document.getElementById("open-new-ability-popup-btn");
const abilityCloseBtn = document.getElementById("close-new-ability-popup");
const abilityOverlay = document.getElementById("popup-new-ability-overlay");
const abilityForm = document.getElementById('new-ability-form');

// Event listeners for button clicks
abilityOpenBtn.addEventListener("click", () => {
  openPopup(abilityOverlay);
});
abilityCloseBtn.addEventListener("click", () => {
  closePopup(abilityOverlay);
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === abilityOverlay) {
    closePopup(abilityOverlay);
  }
});

// Add Submit event listeners
abilityForm.addEventListener('submit', function (event) {
    event.preventDefault();
    submitNewItem('ability', '999', abilityOverlay);
});


// NEW item
// Get Constant elements
const itemOpenBtn = document.getElementById("open-new-item-popup-btn");
const itemCloseBtn = document.getElementById("close-new-item-popup");
const itemOverlay = document.getElementById("popup-new-item-overlay");
const itemForm = document.getElementById('new-item-form');

// Event listeners for button clicks
itemOpenBtn.addEventListener("click", () => {
  openPopup(itemOverlay);
});
itemCloseBtn.addEventListener("click", () => {
  closePopup(itemOverlay);
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === itemOverlay) {
    closePopup(itemOverlay);
  }
});

// Add Submit event listeners
itemForm.addEventListener('submit', function (event) {
    event.preventDefault();
    submitNewItem('item', '9999', itemOverlay);
});


// NEW SPELL
// Get Constant elements
const spellOpenBtn = document.getElementById("open-new-spell-popup-btn");
const spellCloseBtn = document.getElementById("close-new-spell-popup");
const spellOverlay = document.getElementById("popup-new-spell-overlay");
const spellForm = document.getElementById('new-spell-form');

// Event listeners for button clicks
spellOpenBtn.addEventListener("click", () => {
  openPopup(spellOverlay);
});
spellCloseBtn.addEventListener("click", () => {
  closePopup(spellOverlay);
});

// Optional: Close the popup if the user clicks outside the form
window.addEventListener("click", function(event) {
  if (event.target === spellOverlay) {
    closePopup(spellOverlay);
  }
});

// Add Submit event listeners
spellForm.addEventListener('submit', function (event) {
    event.preventDefault();
    submitNewItem('spell', '20', spellOverlay);
});
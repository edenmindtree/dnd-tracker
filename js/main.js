// Global Constants
const trashSvg = '<svg class="trash-icon" onclick="removeItem(this)"><use xlink:href="#trash-icon"></use></svg>'

function setTotalLevel() {
    // 1. Select all input elements with the class 'amount'
    const inputs = document.querySelectorAll('input.class-input');
    let total = 0;

    // 2. Iterate through the inputs and sum their values
    inputs.forEach(input => {
        // Convert the string value from the input to a number
        // Use Number() for potential decimals, or parseInt() for integers only.
        const value = Number(input.value) || 0; 
        total += value;
    });

    // 3. Set the total to the target display element
    const resultElement = document.getElementById('total-level');
    
    // Check if the result element is a text display (span, div, p) or another input
    if (resultElement.tagName === 'INPUT') {
        resultElement.value = total; // Set the value property for inputs
    } else {
        resultElement.textContent = total; // Set the text content for other elements
    }
}

// Generic Functions
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
function submitNewItem(itemType, itemMax) {
  const nameValue = document.getElementById(`new-${itemType}`).value;
  const quanValue = document.getElementById(`new-${itemType}-quan`).value;

  const count = getHighestListNumber(`#${itemType}-list li`)

  addToList(`${itemType}-list`, `<input type="number" class="${itemType}-input" id="${itemType}-${count}" name="${itemType}-${count}" min="0" max="${itemMax}" step="1" value="${quanValue}"> ${nameValue} ${trashSvg}`);
  setTotalLevel();
  closePopup(abilityOverlay);
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

// Starter function to load with page
setTotalLevel();

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
    submitNewItem('ability', '999');
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
    submitNewItem('item', '9999');
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
    submitNewItem('spell', '20');
});
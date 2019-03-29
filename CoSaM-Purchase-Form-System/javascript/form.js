/**
 * 
 * Javascript code to handle form submission
 * Original creation date: 09/14/18
 * Last modification date: 01/12/19
 * Author: Wyly Andrews
 * 
 * TODO: 
 * 
 * * Vendor Info: 
 * * * S&H Fill-in
 * */


// Initial set-up function
window.onload = function init() {
    // Nothing yet
}

// Current status of form
formStatus = document.getElementById("formStatus");
formStatus.innerHTML = "Creating";

emplName = document.getElementById("emplFirstName").value + " " + document.getElementById("emplLastName").value;
// Fill out ship-to and bill-to address when dropdown is selected
var selectDepartment = document.getElementById("selectDepartment");
function updateAddresses() {
    var department = selectDepartment.value;
    var shipToAddress = document.getElementById("shipToAddress");
    var billToAddress = document.getElementById("billToAddress");

    billToAddress.innerHTML = "NDSU College of Science and Math Business Center" + "<br/>"
        + "Department 2705" + "<br/>"
        + "PO Box 6050" + "<br/>"
        + "Fargo, ND 58108 - 6050";

    switch (department) {
        case "BIO-AGHILL":
            shipToAddress.innerHTML =
                "A Glenn Hill Bldg" + "<br/>"
                + "1306 Centennial Blvd" + "<br/>"
                + "1340 Albrecht Boulevard" + "<br>"
                + "Fargo, ND 58102";
            break;
        case "BIO-STEVENS":
            shipToAddress.innerHTML =
                "Department of Biological Sciences" + "<br/>"
                + "North Dakota State University" + "<br/>"
                + "1340 Bolley Drive, 201 Stevens Hall" + "<br/>"
                + "Fargo, ND 58102";
            break;
        case "CHEM-QBB":
            shipToAddress.innerHTML =
                "Attn: " + emplName + "<br/>"
                + "NDSU Quentin Burdick Building 334" + "<br/>"
                + "1320 Albrecht Blvd" + "<br>"
                + "Fargo, ND 58102";
            break;
        case "CHEM-LADD":
            shipToAddress.innerHTML =
                "Department of Chemistry & Biochemistry" + "<br/>"
                + "NDSU Ladd Hall 208" + "<br/>"
                + "1231 Albrecht Blvd" + "<br/>"
                + "Fargo, ND 58102";
            break;
        case "CPM":
            shipToAddress.innerHTML =
                "Attn: " + emplName + "<br/>"
                + "Research 1, Room 216" + "<br/>"
                + "1735 NDSU Research Park Drive North" + "<br/>"
                + "Fargo, North Dakota 58102";
            break;
        case "CSCI":
            shipToAddress.innerHTML =
                "Quentin Burdick Building Room 258" + "<br/>"
                + "1320 Albrecht Boulevard" + "<br/>"
                + "Fargo, ND 58102";
            break;
        case "GEO":
            shipToAddress.innerHTML =
                "North Dakota State University" + "<br/>"
                + "1340 Bolley Drive, 201 Stevens Hall" + "<br/>"
                + "Fargo, ND 58102";
            break;
        case "MATH":
            shipToAddress.innerHTML =
                "NDSU Dept 2750" + "<br/>"
                + "1210 Albrecht Blvd" + "<br/>"
                + "Fargo, ND 58105";
            break;
        case "PHYS":
            shipToAddress.innerHTML =
                "NDSU Dept 2755" + "<br/>"
                + "1211 Albrecht Blvd" + "<br/>"
                + "Fargo, ND 58105";
            break; 
        case "PSYC":
            shipToAddress.innerHTML =
                "NDSU Dept 2765" + "<br/>"
                + "1210 Albrecht Blvd" + "<br/>"
                + "Fargo, ND 58105";
            break;
        case "STAT":
            shipToAddress.innerHTML =
                "NDSU Dept 2770" + "<br/>"
                + "1230 Albrecht Blvd" + "<br/>"
                + "Fargo, ND 58105";
            break;
        default:
            shipToAddress.innerHTML = "Please enter a valid department.";
    }
}
selectDepartment.addEventListener("change", function () { updateAddresses(); });
updateAddresses();

// Keep unit price and total price to two decimal places
moneyElements = document.getElementsByClassName("money");
function createEventForMoneyElements(moneyElement) {
    moneyElement.addEventListener("change", function () {
        this.value = parseFloat(this.value).toFixed(2);
    })
}
for (i = 0; i < moneyElements.length; i++) {
    createEventForMoneyElements(moneyElements[i]);
}


// Add a new line of product so multiple products can be purchased each form

// Remove all random text nodes from <tr id="row"></tr> and <tbody></tbody>
var productRow = document.getElementById("row");
productRow.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});
var productBody = productRow.parentNode;
productBody.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});

// Modify totalPrice when quantity or unitPrice is changed
var quantity = document.getElementsByName("productQuantity[]");
var unitPrice = document.getElementsByName("productUnitPrice[]");
var totalPrice = document.getElementsByName("productTotalAmount[]");
const shippingHandling = document.getElementById("shippingHandlingCost");
const additionalFees = document.getElementById("additionalCost");
const labelFinalTotal = document.getElementById("labelTotalCost");
const finalTotal = document.getElementById("totalCost");

function solveForTotalPrice(rowIndex) {
    q = quantity[rowIndex].value;
    u = unitPrice[rowIndex].value;

    // Round to two decimal places
    output = Math.round(100 * q * u) / 100;

    // Leading zeroes
    totalPrice[rowIndex].value = parseFloat(output).toFixed(2);

    var finalTotalAmount = 0.00;

    for (var i = 0; i < totalPrice.length; i++) {
        finalTotalAmount += parseFloat(totalPrice[i].value);
    }
    finalTotalAmount += parseFloat(shippingHandling.value);
    finalTotalAmount += parseFloat(additionalFees.value);
    labelFinalTotal.innerHTML = parseFloat(finalTotalAmount).toFixed(2);
    finalTotal.value = parseFloat(finalTotalAmount).toFixed(2);

	// Update warning
	var warningTotalCost = document.getElementById("warningTotalCost");
	if ( finalTotalAmount >= 10000 ) {
		warningTotalCost.style.visibility = "visible";
		warningTotalCost.innerHTML = "Order cannot be over $10,000.";
	}
	else {
		warningTotalCost.style.visibility = "hidden";
		warningTotalCost.innerHTML = "";
	}
}

quantity[0].addEventListener("input", function () { solveForTotalPrice(0); this.value = Math.abs(this.value); });
unitPrice[0].addEventListener("input", function () { solveForTotalPrice(0); this.value = Math.abs(this.value); });
totalPrice[0].addEventListener("input", function () { solveForTotalPrice(0); this.value = Math.abs(this.value); });
shippingHandling.addEventListener("input", function () { solveForTotalPrice(0); this.value = Math.abs(this.value); });
additionalFees.addEventListener("input", function () { solveForTotalPrice(0); this.value = Math.abs(this.value); });

solveForTotalPrice(0); // Call to confirm

// Clone a copy of the product row for use each time a row needs to be added
var productRow = productRow.cloneNode(true);
//var cloneCounter = 0; // Used for IDs

var totalProductRows = 1; // Starts at 1 but changes each time one is removed or added

// Add a new product line at the end
function addButtonFunction(addButton) {

    // Edge case to add in the first subtractButton
    if (totalProductRows == 1) {
        var firstSubtractButton = addButton.parentNode.previousSibling.firstChild;
        firstSubtractButton.style.visibility = "visible";
        firstSubtractButton.disabled = false;
    }

    totalProductRows += 1;
    //cloneCounter += 1;
    var newProductRow = productRow.cloneNode(true);
    //newProductRow.find('[id]').each(function () { this.id += cloneCounter; });
    addButton.parentNode.parentNode.parentNode.appendChild(newProductRow); //Add the row at the end
    addButton.style.visibility = "hidden";
    addButton.disabled = true;

    var newAddButton = newProductRow.lastChild.firstChild;
    newAddButton.addEventListener("click", function() { addButtonFunction(newAddButton); });

    var newSubtractButton = newProductRow.lastChild.previousSibling.firstChild;
    newSubtractButton.style.visibility = "visible";
    newSubtractButton.disabled = false;
    newSubtractButton.addEventListener("click", function () { subtractButtonFunction(newSubtractButton); });

    // Add event listeners to solve for unit price
    quantity = document.getElementsByName("productQuantity[]");
    unitPrice = document.getElementsByName("productUnitPrice[]");
    totalPrice = document.getElementsByName("productTotalAmount[]");

    let index = totalProductRows - 1;
    let newQuantity = quantity[index];
    let newUnitPrice = unitPrice[index];
    let newTotalPrice = totalPrice[index];

    newQuantity.addEventListener("input", function () {
        
        solveForTotalPrice(index);
        this.value = Math.abs(this.value);
    });
    newUnitPrice.addEventListener("input", function () {
        
        solveForTotalPrice(index);
        this.value = Math.abs(this.value);
    });
    newTotalPrice.addEventListener("input", function () {

        solveForTotalPrice(index);
        this.value = Math.abs(this.value);
    });

    // Call once to confirm
    solveForTotalPrice(totalProductRows - 1);
}

// Remove the current line of products
function subtractButtonFunction(subtractButton) {

    var currentRow = subtractButton.parentNode.parentNode;

    //Last child, so make a new add button
    if (currentRow == currentRow.parentNode.lastChild) {
        // Find the add button
        var previousRow = currentRow.previousSibling;
        var previousAddButton = previousRow.lastChild.firstChild;

        // Modify the add button
        previousAddButton.style.visibility = "visible";
        previousAddButton.disabled = false;
    }

    //Second to last row, so disable last subtract button
    if (totalProductRows == 2) {
        if (currentRow == currentRow.parentNode.lastChild) {
            var previousRow = currentRow.previousSibling;
            var lastSubtractButton = previousRow.lastChild.previousSibling.firstChild;
        } else {
            var nextRow = currentRow.parentNode.lastChild;
            var lastSubtractButton = nextRow.lastChild.previousSibling.firstChild;
        }
        // Modify the subtract button
        lastSubtractButton.style.visibility = "hidden";
        lastSubtractButton.disabled = true;
    }

    // Remove row
    currentRow.parentNode.removeChild(currentRow);
    totalProductRows -= 1;

    // Readjust event listeners
    quantity = document.getElementsByName("productQuantity[]");
    unitPrice = document.getElementsByName("productUnitPrice[]");
    totalPrice = document.getElementsByName("productTotalAmount[]");

    for (let i = 0; i < quantity.length; i++) {
        let qValue = quantity[i].value;
        quantity[i].outerHTML = quantity[i].outerHTML;
        quantity[i].value = qValue;

        let uValue = unitPrice[i].value;
        unitPrice[i].outerHTML = unitPrice[i].outerHTML;
        unitPrice[i].value = uValue;

        let tValue = totalPrice[i].value;
        totalPrice[i].outerHTML = totalPrice[i].outerHTML;
        totalPrice[i].value = tValue;

        quantity[i].addEventListener("input", function () {

            solveForTotalPrice(i);
            this.value = Math.abs(this.value);
        });

        unitPrice[i].addEventListener("input", function () {

            solveForTotalPrice(i);
            this.value = Math.abs(this.value);
        });

        totalPrice[i].addEventListener("input", function () {

            solveForTotalPrice(i);
            this.value = Math.abs(this.value);
        });
    }

    // Adjust for the deleted row
    solveForTotalPrice(0);
}

// Add event listeners for the original buttons
var addButton = document.getElementById("addButton");
addButton.addEventListener("click", function () { addButtonFunction(addButton); });
var subtractButton = document.getElementById("subtractButton");
subtractButton.addEventListener("click", function () { subtractButtonFunction(subtractButton); });

// Displays error messages
var totalCost = document.getElementById("totalCost");
var warningTotalCost = document.getElementById("warningTotalCost");
if ( totalCost >= 10000 ) {
	warningTotalCost.style.visibility = "visible";
	warningTotalCost.innerHTML = "Order cannot be over $10,000.";
}
else {
	warningTotalCost.style.visibility = "hidden";
	warningTotalCost.innerHTML = "";
}

// Pads a given integer with 0s until the int is as long as the given width
function pad(intToPad, width) {
    intToPad += ''; //Turn to String
    while (intToPad.length < width)
        intToPad = "0" + intToPad;
    return intToPad;
}

function validateMyForm() {
	// prevent costs greater than 10000
	var totalCost = document.getElementById("totalCost");
	return (totalCost.value < 10000);
}
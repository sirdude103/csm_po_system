// JavaScript source code

/**
 * 
 * Javascript code to handle viewing orders
 * Original creation date: 01/13/19
 * Last modification date: 01/14/19
 * Author: Wyly Andrews
 * 
 * */

 // Add event listeners for the original buttons
var addButton = document.getElementById("addButton");
addButton.addEventListener("click", function () { addButtonFunction(addButton); });

var subtractButton = document.getElementById("subtractButton");
subtractButton.addEventListener("click", function () { subtractButtonFunction(subtractButton); });

var sortAddButton = document.getElementById("sortAddButton");
sortAddButton.addEventListener("click", function () { sortAddButtonFunction(sortAddButton); });
var sortSubtractButton = document.getElementById("sortSubtractButton");
sortSubtractButton.addEventListener("click", function () { sortSubtractButtonFunction(sortSubtractButton); });


 // Remove all random text nodes from <tr id="searchRow"></tr> and <tbody></tbody>
var searchRow = document.getElementById("searchRow");
searchRow.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});
var searchBody = searchRow.parentNode;
searchBody.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});

var sortRow = document.getElementById("sortRow");
sortRow.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});
var sortBody = sortRow.parentNode;
sortBody.childNodes.forEach(function (child) {
    if (child.nodeType == Node.TEXT_NODE) { child.parentNode.removeChild(child);}
});


 // Clone search row
var searchRow = searchRow.cloneNode(true);
var totalSearchRows = 1; // Starts at 1 but changes each time one is removed or added

// Clone sort row
var sortRow = sortRow.cloneNode(true);
var totalSortRows = 1; // Starts at 1 but changes each time one is removed or added

// Add a new search line at the end
function addButtonFunction(addButton) {

    // Edge case to add in the first subtractButton
    if (totalSearchRows == 1) {
        var firstSubtractButton = addButton.parentNode.previousSibling.firstChild;
        firstSubtractButton.style.visibility = "visible";
        firstSubtractButton.disabled = false;
    }

	totalSearchRows += 1;


    var newSearchRow = searchRow.cloneNode(true);
	addButton.parentNode.parentNode.parentNode.appendChild(newSearchRow); //Add the row at the end
    addButton.style.visibility = "hidden";
    addButton.disabled = true;
	
	var newAddButton = newSearchRow.lastChild.firstChild;
    newAddButton.addEventListener("click", function() { addButtonFunction(newAddButton); });

	var newSubtractButton = newSearchRow.lastChild.previousSibling.firstChild;
    newSubtractButton.style.visibility = "visible";
    newSubtractButton.disabled = false;
    newSubtractButton.addEventListener("click", function () { subtractButtonFunction(newSubtractButton); });

	if (totalSearchRows >= 3) {
		newAddButton.style.visibility = "hidden";
		newAddButton.disabled = true;
	}
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

	if (totalSearchRows == 3) {
		if (currentRow == currentRow.parentNode.lastChild) {
			var previousRow = currentRow.previousSibling;
			var addButton = previousRow.lastChild.firstChild;
		} else {
			var nextRow = currentRow.parentNode.lastChild;
			var addButton = nextRow.lastChild.firstChild;
        } 

		// Modify the add button
        addButton.style.visibility = "visible";
        addButton.disabled = false;
	}

	//Second to last row, so disable last subtract button
    if (totalSearchRows == 2) {
        if (currentRow == currentRow.parentNode.lastChild) {
            var previousRow = currentRow.previousSibling;
            var lastSubtractButton = previousRow.lastChild.previousSibling.firstChild;
        } else {
            var nextRow = currentRow.parentNode.lastChild;
            var lastSubtractButton = nextRow.lastChild.previousSibling.firstChild;
        }
        // Modify the button
        lastSubtractButton.style.visibility = "hidden";
        lastSubtractButton.disabled = true;
    }

	// Remove row
    currentRow.parentNode.removeChild(currentRow);
    totalSearchRows -= 1;
}

// Add a new sort line at the end
function sortAddButtonFunction(addButton) {

    // Edge case to add in the first subtractButton
    if (totalSortRows == 1) {
        var firstSubtractButton = addButton.parentNode.previousSibling.firstChild;
        firstSubtractButton.style.visibility = "visible";
        firstSubtractButton.disabled = false;
    }

	totalSortRows += 1;


    var newSortRow = sortRow.cloneNode(true);
	addButton.parentNode.parentNode.parentNode.appendChild(newSortRow); //Add the row at the end
    addButton.style.visibility = "hidden";
    addButton.disabled = true;
	
	var newAddButton = newSortRow.lastChild.firstChild;
    newAddButton.addEventListener("click", function() { sortAddButtonFunction(newAddButton); });

	var newSubtractButton = newSortRow.lastChild.previousSibling.firstChild;
    newSubtractButton.style.visibility = "visible";
    newSubtractButton.disabled = false;
    newSubtractButton.addEventListener("click", function () { sortSubtractButtonFunction(newSubtractButton); });

	if (totalSortRows >= 3) {
		newAddButton.style.visibility = "hidden";
		newAddButton.disabled = true;
	}
}

// Remove the current line of products
function sortSubtractButtonFunction(subtractButton) {

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

	if (totalSortRows == 3) {
		if (currentRow == currentRow.parentNode.lastChild) {
			var previousRow = currentRow.previousSibling;
			var addButton = previousRow.lastChild.firstChild;
		} else {
			var nextRow = currentRow.parentNode.lastChild;
			var addButton = nextRow.lastChild.firstChild;
        } 

		// Modify the add button
        addButton.style.visibility = "visible";
        addButton.disabled = false;
	}

	//Second to last row, so disable last subtract button
    if (totalSortRows == 2) {
        if (currentRow == currentRow.parentNode.lastChild) {
            var previousRow = currentRow.previousSibling;
            var lastSubtractButton = previousRow.lastChild.previousSibling.firstChild;
        } else {
            var nextRow = currentRow.parentNode.lastChild;
            var lastSubtractButton = nextRow.lastChild.previousSibling.firstChild;
        }
        // Modify the button
        lastSubtractButton.style.visibility = "hidden";
        lastSubtractButton.disabled = true;
    }

	// Remove row
    currentRow.parentNode.removeChild(currentRow);
    totalSortRows -= 1;
}

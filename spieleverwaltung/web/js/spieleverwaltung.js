// This function is called, when the button #switchButton is clicked.
// The function is responsible for toggling classes 'theme-gamecube' / 'theme-controller'
function switchClasses() {

    // Getting all html elements from DOM.
    // The variable contains all html elements from the document.
    var domElements = document.getElementsByTagName('*');

    // Store them in an extra variable, so the list is not being updated immediately
    var domElementsCopy = [].slice.call(domElements, 0);

    // Iterate over the copy of dom element array
    for (var i = 0; i < domElementsCopy.length; ++i) {

        // If the current element contains 'theme-gamecube' in its' class names, change it to class 'theme-controller'
        if (domElementsCopy[i].classList.contains('theme-gamecube')) {
            domElementsCopy[i].classList.remove('theme-gamecube');
            domElementsCopy[i].classList.add('theme-controller');

            // Continue the loop with the next item and skip code below
            continue;
        }

        // If the current element does not contain 'theme-gamecube' in its' class names, but 'theme-controller', invert the names
        if (domElementsCopy[i].classList.contains('theme-controller')) {
            domElementsCopy[i].classList.remove('theme-controller');
            domElementsCopy[i].classList.add('theme-gamecube');

            // A "continue" is not required here since it's the last part of the loop
        }

        // Since we also have other elements we do not want to change we work with two if-conditions
        // instead of an if/else-construction. This way we can make sure the other elements are not
        // changed.
    }

}

function w3_open() {
    document.getElementById("mySidebar").style.width = "100%";
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
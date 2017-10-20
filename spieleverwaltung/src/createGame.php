<?php
// Filling the array and defining the datatypes
$newGame = array(
    'name' => htmlspecialchars($_POST['spieleName']),
    'developerId' => (int) htmlspecialchars($_POST['spieleEntwickler']),
    'deviceId' => (int) htmlspecialchars($_POST['geräteName']),
    'mediumTypeId' => (int) htmlspecialchars($_POST['spieleMedium']),
);

// Check if any required field is empty
foreach ($newGame as $key => $formValue) {
    if (empty($formValue)) {
        $_SESSION['error'] = "Input " . $key . " is empty.";
        header('Location: http://localhost/spieleverwaltung/index.php');
        return;
    }

    // Check if any invalid insertion was committed
    if ((strpos($formValue, "\\") !== false) or (strpos($formValue, "/") !== false)) {
        $_SESSION['error'] = "Input " . $key . " contains invalid variable.";
        header('Location: http://localhost/spieleverwaltung/index.php');
        return;
    }
}

//construction of a new string for inserting a new game
$insertQueryString = "INSERT INTO games (name, geraet_id, entwickler_id, medium_id) VALUES (?, ?, ?, ?)";

$GLOBALS['connection'];

// Creating a prepared statement with connection and already formed query string
if ($stmt = mysqli_prepare($GLOBALS['connection'], $insertQueryString)) {
    // Binding of non-initialized parameters and their datatypes
    mysqli_stmt_bind_param($stmt, "siii", $gameName, $deviceId, $developerId, $mediumTypeId);

    // Defining the parameters of the preceding function
    $gameName = $newGame['name'];
    $deviceId = $newGame['deviceId'];
    $developerId = $newGame['developerId'];
    $mediumTypeId = $newGame['mediumTypeId'];
    // Execution of the function
    mysqli_stmt_execute($stmt);

    // Closing the statement-function
    mysqli_stmt_close($stmt);

} else {
    echo("Error description: " . mysqli_error($GLOBALS['connection']));
    die();
}

mysqli_close($GLOBALS['connection']);

header('Location: http://localhost/spieleverwaltung/index.php');

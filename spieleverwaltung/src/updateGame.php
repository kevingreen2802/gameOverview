<?php
// Filling the array and defining the datatypes
$updateGame = array(
    'gameId' => (int) $_POST['gameID'],
    'name' => htmlspecialchars($_POST['spieleName']), // 'htmlspecialchars' converts special characters into HTML entities
    'developerId' => (int) $_POST['developers'],
    'deviceId' => (int) $_POST['devices'],
    'mediumTypeId' => (int) $_POST['mediumtypes']
);

foreach ($updateGame as $key => $formValue) {
    if (empty($formValue)) {
        $_SESSION['error'] = "Error: Field 'Game' must be filled!";
        header('Location: http://localhost/spieleverwaltung/');
        return;
    }

    // Check if any invalid insertion was committed
    if ((strpos($formValue, "\\") !== false) or (strpos($formValue, "/") !== false)) {
        $_SESSION['error'] = "Field " . $key . " contains invalid characters!";
        header('Location: http://localhost/spieleverwaltung/');
        return;
    }
}

// Construction of a new string for updating a game
$updateQueryString = "UPDATE games SET name=?,geraet_id=?,entwickler_id=?,medium_id=? WHERE id=?";

// Creating a prepared statement with connection and already formed query string
if ($stmt = mysqli_prepare($GLOBALS['connection'], $updateQueryString)) {

    // Binding of non-initialized parameters and their datatypes
    mysqli_stmt_bind_param($stmt, "siiii", $gameName, $deviceId, $developerId, $mediumTypeId, $gameId);

    // Defining the parameters of the preceding function
    $gameName = $updateGame['name'];
    $deviceId = $updateGame['deviceId'];
    $developerId = $updateGame['developerId'];
    $mediumTypeId = $updateGame['mediumTypeId'];
    $gameId = $updateGame['gameId'];

    // Execution of the statement
    mysqli_stmt_execute($stmt);

    // Closing the statement-function
    mysqli_stmt_close($stmt);

} else {
    $_SESSION['error'] = "Error description: " . mysqli_error($GLOBALS['connection']);
}
// Closing connection to the database
mysqli_close($GLOBALS['connection']);

// Refreshing the site after updates are done
header('Location: http://localhost/spieleverwaltung/');

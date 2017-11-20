<?php
// Delete game
if (isset($_POST['gameToDelete'])) {

    // Defining the variable for game-deletion
    $deleteGame = (int) $_POST['gameID'];

    // Check if any required field is empty
    if (empty($deleteGame)) {
        $_SESSION['error'] = "Field gameID is empty.";
        return;
    }

    //Construction of the new string to delete entries
    $deleteGameSql = " DELETE FROM games WHERE id = " . $deleteGame;

    // Creating a query
    if (!mysqli_query($GLOBALS['connection'], $deleteGameSql)) {
        $_SESSION['error'] = "Error description: " . mysqli_error($GLOBALS['connection']);
    }

    mysqli_close($GLOBALS['connection']);

    header('Location: http://localhost/spieleverwaltung/');
}

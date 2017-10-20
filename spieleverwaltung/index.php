<?php
if(session_start()) {
// Assign variables for database connection

    if (!isset($GLOBALS['connection'])) {
        $host = "localhost";
        $user = "spieleverwaltungAdmin";
        $password = "dzh123";
        $database = "spieleverwaltung";

        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $GLOBALS['connection'] = mysqli_connect($host, $user, $password, $database);
        } catch (Exception $e ) {
            echo "ERROR: Could not connect to database.";
            exit;
        }
    }

    if (isset($_POST['clearError'])) {
        include 'src/clearError.php';
        return;
    }

    // Create a new game
    if (isset($_POST['createGame'])) {
        include 'src/createGame.php';
        return;
    }

    // Update a game
    if (isset($_POST['updateGame'])) {
        include 'src/updateGame.php';
        return;
    }

    // Delete game
    if (isset($_POST['gameToDelete'])) {
        include 'src/deleteGame.php';
        return;
    }

    if(empty($_POST)){
        include 'src/showAllGames.php';
    }

} else {
    session_start();
}

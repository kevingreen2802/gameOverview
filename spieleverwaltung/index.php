<?php
if (session_status() == PHP_SESSION_NONE || session_id() == '') {
    session_start();
}

// Assign variables for database connection
if (!isset($GLOBALS['connection'])) {
    $host = "localhost";
    $user = "spieleverwaltungAdmin";
    $password = "dzh123";
    $database = "spieleverwaltung";


// Connecting to Database if all variables have been set; displays error if unsuccessful
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $GLOBALS['connection'] = mysqli_connect($host, $user, $password, $database);
    } catch (Exception $e ) {
        $_SESSION['error'] = 'Page not found.';
        include 'src/errorHandling.php';
        exit;
    }
}

// Ignores error
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

//Check if URL contains right attachment
if(isset($_REQUEST['path']) && ($_REQUEST['path'] === "" || $_REQUEST['path'] === "games")){
    include 'src/showAllGames.php';
} else {
    $_SESSION['error'] = 'Page not found.';
    include 'src/errorHandling.php';
}


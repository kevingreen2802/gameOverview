<?php
// Assign variables for database connection
$host = "localhost";
$user = "spieleverwaltungAdmin";
$password = "dzh123";
$database = "spieleverwaltung";

// Create a new game
if (isset($_POST['createGame'])) {

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
            var_dump("Input " . $key . " is empty.");
            die();
        }

        // Check if any invalid insertion was committed
        if (strpos($formValue, "\\") or strpos($formValue, "/")) {
            var_dump("Input " . $key . " contains invalid variable.");
            die();
        }
    }

    //construction of a new string for inserting a new game
    $insertQueryString = "INSERT INTO games (name, geraet_id, entwickler_id, medium_id) VALUES (?, ?, ?, ?)";

     $con = mysqli_connect($host, $user, $password, $database);

    // Creating a prepared statement with connection and already formed query string
    if ($stmt = mysqli_prepare($con, $insertQueryString)) {
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
        echo("Error description: " . mysqli_error($con));
        die();
    }

    mysqli_close($con);

    header('Location: http://localhost/spieleverwaltung/index.php');
}

// Update a game
if (isset($_POST['updateGame'])) {

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
            var_dump("Feld " . $key . " ist leer.");
            die();
        }

        // Check if any invalid insertion was committed
        if (strpos($formValue, "\\") or strpos($formValue, "/")) {
            var_dump("Feld " . $key . " enthält ungültigen Buchstaben.");
            die();
        }
    }

    // Construction of a new string for updating a game
    $updateQueryString = "UPDATE games SET name=?,geraet_id=?,entwickler_id=?,medium_id=? WHERE id=?";

    $con = mysqli_connect($host, $user, $password, $database);

    // Creating a prepared statement with connection and already formed query string
    if ($stmt = mysqli_prepare($con, $updateQueryString)) {

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
        echo("Error description: " . mysqli_error($con));
        die();
    }

    // Closing connection to the database
    mysqli_close($con);

    // Refreshing the site after updates are done
    header('Location: http://localhost/spieleverwaltung/index.php');
}

// Delete game
if (isset($_POST['gameToDelete'])) {

    // Defining the variable for game-deletion
    $deleteGame = (int) $_POST['gameID'];

    // Check if any required field is empty
    if (empty($deleteGame)) {
        var_dump("Feld gameID ist leer.");
        die();
    }

    //Construction of the new string to delete entries
    $deleteGameSql = " DELETE FROM games WHERE id = " . $deleteGame;

    $con = mysqli_connect($host, $user, $password, $database);

    // Creating a query
    if (!mysqli_query($con, $deleteGameSql)) {
        echo("Error description: " . mysqli_error($con));
        die();
    }

    mysqli_close($con);

    header('Location: http://localhost/spieleverwaltung/index.php');
}

//var_dump($_GET);
//die();

$con = mysqli_connect($host, $user, $password, $database);

// Show table with insertions

$selectStatement = "SELECT games.id AS 'Spiele-ID',
          games.name AS 'Spiele-Name',
          devices.name AS 'Geräte-Name',
          company.name AS 'Hersteller-Name',
          developer.name AS 'Entwickler-Name',
          medium.name AS 'Medium-Name',
          devices.id,
          company.id,
          developer.id,
          medium.id
          FROM games 
          INNER JOIN devices 
          ON games.geraet_id = devices.id 
          INNER JOIN company 
          ON devices.hersteller_id = company.id
          INNER JOIN developer
          ON games.entwickler_id = developer.id
          INNER JOIN medium
          ON games.medium_id = medium.id";

    $selectStatement .= " WHERE games.name LIKE '%" . htmlspecialchars($_GET['name']) . "%'
    AND devices.name LIKE '%" . htmlspecialchars($_GET['device']) . "%'
    AND company.name LIKE '%" . htmlspecialchars($_GET['company']) . "%'
    AND developer.name LIKE '%" . htmlspecialchars($_GET['developer']) . "%'
    AND medium.name LIKE '%" . htmlspecialchars($_GET['medium']) . "%'";

$selectStatement .= "ORDER BY games.name";


$res = mysqli_query($con, $selectStatement);

// Creating a query and ejecting existing entries
$developersResult = mysqli_query($con, "SELECT * FROM developer");
$developers = array();
while ($developer = mysqli_fetch_assoc($developersResult)) {
        $developers[] = $developer;
}

$devicesResult = mysqli_query($con, "SELECT * FROM devices");
$devices = array();
while ($device = mysqli_fetch_assoc($devicesResult)) {
        $devices[] = $device;
}

$manufacturersResult = mysqli_query($con, "SELECT * FROM company");
$manufacturers = array();
while ($manufacturer = mysqli_fetch_assoc($manufacturersResult)) {
        $manufacturers[] = $manufacturer;
}

$mediumTypesResult = mysqli_query($con, "SELECT * FROM medium");
$mediumTypes = array();
while ($mediumType = mysqli_fetch_assoc($mediumTypesResult)) {
        $mediumTypes[] = $mediumType;
}

$games = array();
while ($dsatz = mysqli_fetch_assoc($res)) {
        $games[] = $dsatz;
}

mysqli_close($con);

// Including the form
include("spieleverwaltung.html");

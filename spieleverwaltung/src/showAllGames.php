<?php
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

$_SESSION['sortingGames'] = array (
    'column' => 'games.name',
    'order' => 'DESC'
);

$availableFields = array(
    'name' => 'games.name',
    'developer' => 'developer.name',
    'device' => 'devices.name',
    'company' => 'company.name',
    'medium' => 'medium.name',
);

if (!isset($_SESSION['query'])) {
    foreach ($availableFields as $availableField => $tableAndColumn) {
        $_SESSION['query'][$availableField] = null;
    }
}

if (isset($_GET['resetGameSearchEntry'])) {

    foreach ($availableFields as $availableField => $tableAndColumn) {
        $_SESSION['query'][$availableField] = null;
        $_GET[$availableField] = null;
    }

    header('Location: http://localhost/spieleverwaltung/');
}

if (!empty($_GET)) {
    $queryParams = array();

    foreach ($availableFields as $availableField => $tableAndColumn) {

        $searchString = "";
        if (isset($_GET[$availableField])) {
            $searchString = $_GET[$availableField];
            $queryParams[$tableAndColumn] = htmlspecialchars($searchString);
        }

        if ($searchString == '') {
            $_SESSION['query'][$availableField] = null;
        } else {
            $_SESSION['query'][$availableField] = $searchString;
        }
    }

    $firstCondition = false;
    foreach ($queryParams as $key => $value) {
        if (isset($value) && $value !== "") {
            if ($firstCondition === false) {
                $selectStatement .= " WHERE " . $key . " LIKE '%" . $value . "%'";
                $firstCondition = true;
            } else {
                $selectStatement .= " AND " . $key . " LIKE '%" . $value . "%'";
            }
        }
    }
} else {
    foreach ($availableFields as $availableField => $tableAndColumn) {
        $_SESSION['query'][$availableField] = null;
        $_GET[$availableField] = null;
    }
}

$selectStatement .= " ORDER BY games.name";

if ($GLOBALS['connection']) {

    // Creating a query and ejecting existing entries
    $developersResult = mysqli_query($GLOBALS['connection'], "SELECT * FROM developer");
    $developers = array();
    while ($developer = mysqli_fetch_assoc($developersResult)) {
        $developers[] = $developer;
    }

    $devicesResult = mysqli_query($GLOBALS['connection'], "SELECT * FROM devices");
    $devices = array();
    while ($device = mysqli_fetch_assoc($devicesResult)) {
        $devices[] = $device;
    }

    $manufacturersResult = mysqli_query($GLOBALS['connection'], "SELECT * FROM company");
    $manufacturers = array();
    while ($manufacturer = mysqli_fetch_assoc($manufacturersResult)) {
        $manufacturers[] = $manufacturer;
    }

    $mediumTypesResult = mysqli_query($GLOBALS['connection'], "SELECT * FROM medium");
    $mediumTypes = array();
    while ($mediumType = mysqli_fetch_assoc($mediumTypesResult)) {
        $mediumTypes[] = $mediumType;
    }

    $res = mysqli_query($GLOBALS['connection'], $selectStatement);

    // check if mysqli select statement failed
    if (!$res) {
        $_SESSION['error'] = "ERROR: Service unavailablie";
    } else {
        $games = array();
        while ($dsatz = mysqli_fetch_assoc($res)) {
            $games[] = $dsatz;
        }
    }

    mysqli_close($GLOBALS['connection']);

} else {
    $_SESSION['error'] = "ERROR: Service unavailable.";
}

// Including the form
include __DIR__ . '/../pages/showAllGames.html';

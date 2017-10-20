<?php
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
header('Location: http://localhost/spieleverwaltung/index.php');
<?php
$mysqli = mysqli_connect('mariadb', 'cs332b24', 'EODb2NbN', 'cs332b24');
if (!$mysqli) {
    die('Could not connect to database: ' . mysqli_error());
}
?>

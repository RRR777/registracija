<?php
function connect(){
    $servername = 'localhost';
    $dbname = 'registration';
    $username = 'Laravel';
    $password = '1234554321';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Nepavyko prisjungti: ' . $conn->connect_error);
    }
    return $conn;
}
?>
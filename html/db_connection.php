

<?php
    $servername = "localhost";
    $username = "CinemasDB";
    $password = "DB";
    $dbname = "mbocinema";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
    }
    echo "Database connected successfully <br/>";

?> 
<?php
// Start the session 
session_start();

// Include database connection file 
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input form form
    $username = trim($_POST['uname']);
    $password = trim($_POST['psw']);
    $email = trim($_POST['eml']);
    $telefoonnumer = trim($_POST['tel']);

}


  // Check for empty fields 
    if (empty($username) || empty($password) || empty($email)|| empty($telefoonnumer)) { 
        echo "je hebt nog niet alles ingevuld"; 
        exit; 
    }
    
    $Hashed_password = password_hash($password);
   


$stmt = $conn->prepare("SELECT Id, UserPassword FROM users WHERE UserName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Check if username exists 
if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    echo "User bestaat al";
} else {
    $sql = "INSERT INTO users (UserName, UserPassword, email, telefoonnumer) VALUES ('$username', '$Hashed_password', '$email', '$telefoonnumer')";
    echo "New user created successfully";
}
// if (mysqli_query($conn, $sql)) {
//   echo "New user created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

mysqli_close($conn);
?>
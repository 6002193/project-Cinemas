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
    
   else {$Hashed_password = password_hash($password, PASSWORD_DEFAULT);
   }


$stmt = $conn->prepare("SELECT Id FROM users WHERE UserName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Check if username exists 
// if ($stmt->num_rows == 1) {
//     $stmt->bind_result($id, $hashed_password);
//     $stmt->fetch();
//     echo "User bestaat al";
if ($stmt->num_rows > 0) {

        // Display the alert box 
        echo '<script>
        alert("Deze gebruikersnaam bestaat al.");
        window.location.href="acountmaken.php";
        </script>'; 

    } else {
         $Hashed_password = password_hash($password, PASSWORD_DEFAULT);
         

   // Insert new user
        $insert = $conn->prepare("INSERT INTO users (UserName, UserPassword, email, telefoonnumer) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $username, $Hashed_password, $email, $telefoonnumer);

        if ($insert->execute()) {
            echo "Nieuwe gebruiker succesvol aangemaakt.";
   
            // Redirect to the protected page 
            header("Location: inloggen.php");            
            exit; 

        } else {

            // Display the alert box 
            echo '<script>
            alert("Fout bij het aanmaken van de gebruiker.");
            window.location.href="acountmaken.php";
            </script>';  

        }

        $insert->close();
    }

    $stmt->close();
    $conn->close();

?>
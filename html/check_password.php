<?php 
// Start the session 
session_start(); 
 
// Include database connection file 
include 'db_connection.php';  
 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Validate input form form
    $username = trim($_POST['uname']); 
    $password = trim($_POST['psw']); 
 
    // Check for empty fields 
    if (empty($username) || empty($password)) { 
        echo "Username and password cannot be empty."; 
        exit; 
    } 
 
    // Prepare a SQL statement to prevent SQL injection 
    $stmt = $conn->prepare("SELECT Id, UserPassword FROM users WHERE UserName = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute(); 
    $stmt->store_result(); 
 
    // Check if username exists 
    if ($stmt->num_rows == 1) { 
        $stmt->bind_result($id, $hashed_password); 
        $stmt->fetch(); 

        // Verify the password 
        if (password_verify($password, $hashed_password)) { 
            // Password is correct            
            echo "Login successful!"; 

            // Store naam in session
            $_SESSION["username"] = $username;

            // Redirect to the protected page 
            header("Location: ingelogd.php"); 
            exit; 
        } else { 
            echo "Invalid password."; 
        } 
    } else { 
        echo "No user found with that username."; 
    } 
 
    // Close the statement 
    $stmt->close(); 
} 
 
// Close the database connection 
$conn->close(); 
?> 
<?php 
// Start the session 
session_start(); 
 
// Include database connection file 
include 'db_connection.php';  
 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Validate input from form
    $username = trim($_POST['uname']); 
    $password = trim($_POST['psw']); 
 
    // Check for empty fields 
    if (empty($username) || empty($password)) { 
        echo "Username and password cannot be empty."; 
        exit; 
    } 
 
    // Prepare a SQL statement to prevent SQL injection 
    // Let ook admin ophalen in je query
    $stmt = $conn->prepare("SELECT Id, UserPassword, is_admin FROM users WHERE UserName = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute(); 
    $stmt->store_result(); 
 
    // Check if username exists 
    if ($stmt->num_rows == 1) { 
        $stmt->bind_result($id, $hashed_password, $admin); 
        $stmt->fetch(); 
 
        // Verify the password 
        if (password_verify($password, $hashed_password)) { 
            // Password is correct            
            echo "Login successful!"; 
 
            // Store gegevens in session
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $id;
            $_SESSION['admin'] = $admin;  // <-- hier gebruiken we admin van DB
 
            // Redirect to the protected page 
            header("location: index.php"); 
            exit; 
        } else { 
            echo '<script>
            alert("Login mislukt.");
            window.location.href="inloggen.php";
            </script>';
            exit;
        }
    } else { 
        echo '<script>
        alert("Login mislukt.");
        window.location.href="inloggen.php";
        </script>';      
        exit;
    } 
 
    // Close the statement 
    $stmt->close(); 
} 
 
// Close the database connection 
$conn->close(); 
?>

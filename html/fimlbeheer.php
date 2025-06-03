<?php
// Foutmeldingen aanzetten voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Variabelen initiëren
$melding = "";

// Als het formulier is verzonden:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'] ?? '';
    $rating = $_POST['rating'] ?? '';

    // Verbinden met de database
$conn = new mysqli("localhost", "root", "", "mbocinema");

    // Verbinding checken
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    // Insert uitvoeren met prepared statement
    $stmt = $conn->prepare("INSERT INTO movies (naam, rating) VALUES (?, ?)");
    $stmt->bind_param("si", $naam, $rating);

    if ($stmt->execute()) {
        $melding = "✅ Film succesvol toegevoegd!";
    } else {
        $melding = "❌ Fout bij toevoegen: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Een korte omschrijving van je website die in zoekmachines verschijnt.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="Movie, MboCinemas, MovieTheatre">
  <meta name="author" content="Jelle Groen">
  <title>Mbo Cinema</title>
  <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <nav>
      <a href="index.html" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="fimlbeheer.php">filmbeheer</a></li>
        <li><a href="zaaleheer.html">zaalbeheer</a></li>
        <li><a href="reservering.html">reserveringbeheer</a></li>
        <li><a href="Account_admin.html">accountbeheer</a></li>
      </ul>
      <a href="Account_admin.html">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main>
    <h2>Voeg een film toe</h2>
    <?php if (!empty($melding)) echo "<p>$melding</p>"; ?>
    <form method="POST" action="fimlbeheer.php">
      <label for="naam">Filmtitel:</label><br>
      <input type="text" id="naam" name="naam" required><br><br>

      <label for="rating">PEGI Rating:</label><br>
      <input type="number" id="rating" name="rating" min="0" max="18" required><br><br>

      <input type="submit" value="Voeg toe">
    </form>
  </main>
</body>
</html>

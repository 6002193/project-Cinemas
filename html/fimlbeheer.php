<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$melding = "";

// Verwijderen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verwijder_id'])) {
    $verwijder_id = $_POST['verwijder_id'];

    $conn = new mysqli("localhost", "root", "", "mbocinema");
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM movies WHERE naam = ?");
    $stmt->bind_param("s", $verwijder_id);

    if ($stmt->execute()) {
        $melding = " Film verwijderd!";
    } else {
        $melding = " Fout bij verwijderen: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

// Toevoegen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['naam'], $_POST['rating']) && empty($_POST['verwijder_id'])) {
    $naam = $_POST['naam'];
    $rating = $_POST['rating'];

    $conn = new mysqli("localhost", "root", "", "mbocinema");
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO movies (naam, rating) VALUES (?, ?)");
    $stmt->bind_param("si", $naam, $rating);

    if ($stmt->execute()) {
        $melding = " Film succesvol toegevoegd!";
    } else {
        $melding = " Fout bij toevoegen: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

// Ophalen van alle films
$conn = new mysqli("localhost", "root", "", "mbocinema");
$films = [];
if (!$conn->connect_error) {
    $result = $conn->query("SELECT * FROM movies");
    if ($result) {
        $films = $result->fetch_all(MYSQLI_ASSOC);
    }
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
    <form method="POST" action="fimlbeheer.php" class="toevoeg-pagina">
      <label for="naam">Filmtitel:</label><br>
      <input type="text" id="naam" name="naam" required><br><br>

      <label for="rating">PEGI Rating:</label><br>
      <input type="number" id="rating" name="rating" min="0" max="18" required><br><br>

      <input type="submit" value="Voeg toe">
    </form>

<h2>Bestaande films</h2>
<div class="film-lijst">
  <?php foreach ($films as $film): ?>
    <div class="film-item">
      <div><?= htmlspecialchars($film['naam']) ?></div>
      <div><?= htmlspecialchars($film['rating']) ?></div>
      <form method="POST" action="fimlbeheer.php" onsubmit="return confirm('Weet je zeker dat je deze film wilt verwijderen?');">
        <input type="hidden" name="verwijder_id" value="<?= $film['naam'] ?>">
        <button type="submit">Verwijder</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>

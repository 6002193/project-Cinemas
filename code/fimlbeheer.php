<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'classes/Film.php';

$melding = "";
$conn = new mysqli("localhost", "root", "", "mbocinema");
if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

$repo = new FilmRepository($conn);

// Verwijderen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verwijder_id'])) {
    $melding = $repo->deleteByName($_POST['verwijder_id']) ? "Film verwijderd!" : "Fout bij verwijderen.";
}

// Toevoegen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['naam'], $_POST['rating'], $_POST['seats']) && empty($_POST['verwijder_id'])) {
    $naam = $_POST['naam'];
    $rating = (int)$_POST['rating'];
    $room = $_POST['room'] !== "" ? (int)$_POST['room'] : null;
    $seats = (int)$_POST['seats'];
    $foto_url = $_POST['foto_url'] ?? null;
    $melding = $repo->add($naam, $rating, $room, $seats, $foto_url) ? "Film succesvol toegevoegd!" : "Fout bij toevoegen.";
}

// Ophalen van alle films
$films = $repo->getAll();
$conn->close();
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
      <a href="index.php" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="">filmbeheer</a></li>
        <li><a href="zaalbeheer.php">zaalbeheer</a></li>
        <li><a href="reservering.php">reserveringbeheer</a></li>
        <li><a href="accounts.php">accountbeheer</a></li>
      </ul>
      <a href="Account_admin.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main class="filmbeheer-main">
    <section class="toevoeg-container">
      <h2>Bestaande films</h2>
      <?php if (!empty($melding)) echo "<p>$melding</p>"; ?>
      <form method="POST" action="fimlbeheer.php" class="toevoeg-pagina">
        <label for="naam">Filmtitel:</label><br>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="rating">PEGI Rating:</label><br>
        <input type="number" id="rating" name="rating" min="0" max="18" required><br><br>

        <label for="room">Kamernummer:</label><br>
        <input type="number" id="room" name="room"><br><br>

        <label for="seats">Stoelen:</label><br>
        <input type="number" id="seats" name="seats" required><br><br>

        <label for="foto_url">Afbeeldingslink:</label><br>
        <input type="url" id="foto_url" name="foto_url"><br><br>

        <input type="submit" value="Voeg toe">
      </form>
    </section>

    <section class="film-lijst">
      <?php foreach ($films as $film): ?>
        <section class="film-item">
          <p><?= htmlspecialchars($film->getNaam()) ?></p>
          <p><?= htmlspecialchars($film->getRating()) ?></p>
          <form method="POST" action="fimlbeheer.php" onsubmit="return confirm('Weet je zeker dat je deze film wilt verwijderen?');">
            <input type="hidden" name="verwijder_id" value="<?= htmlspecialchars($film->getNaam()) ?>">
            <button type="submit">Verwijder</button>
          </form>
          <?php if (!empty($film->getFotoUrl())): ?>
            <img src="<?= htmlspecialchars($film->getFotoUrl()) ?>" alt="Filmfoto" style="width: 100px; height: auto;">
          <?php endif; ?>
        </section>
      <?php endforeach; ?>
    </section>
  </main>
  <script type="module" src="javascript/zoekfunctie.js"></script>
</body>
</html>


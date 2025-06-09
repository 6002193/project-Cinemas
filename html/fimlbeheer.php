<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$melding = "";

// Connectie
$conn = new mysqli("localhost", "root", "", "mbocinema");
if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

// Verwijderen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verwijder_id'])) {
    $stmt = $conn->prepare("DELETE FROM movies WHERE naam = ?");
    $stmt->bind_param("s", $_POST['verwijder_id']);
    $melding = $stmt->execute() ? "Film verwijderd!" : "Fout bij verwijderen: " . $conn->error;
    $stmt->close();
}

// Toevoegen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['naam'], $_POST['rating'], $_POST['seats']) && empty($_POST['verwijder_id'])) {
    $naam = $_POST['naam'];
    $rating = $_POST['rating'];
    $seats = $_POST['seats'];
    $foto_url = $_POST['foto_url'] ?? null;

    if (empty($_POST['room'])) {
        $stmt = $conn->prepare("INSERT INTO movies (naam, rating, room, seats, foto_url) VALUES (?, ?, NULL, ?, ?)");
        $stmt->bind_param("siis", $naam, $rating, $seats, $foto_url);
    } else {
        $room = $_POST['room'];
        $stmt = $conn->prepare("INSERT INTO movies (naam, rating, room, seats, foto_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $naam, $rating, $room, $seats, $foto_url);
    }

    $melding = $stmt->execute() ? "Film succesvol toegevoegd!" : "Fout bij toevoegen: " . $conn->error;
    $stmt->close();
}

// Ophalen van alle films
$films = [];
$result = $conn->query("SELECT * FROM movies");
if ($result) {
    $films = $result->fetch_all(MYSQLI_ASSOC);
}
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
        <li><a href="fimlbeheer.php">filmbeheer</a></li>
        <li><a href="zaaleheer.php">zaalbeheer</a></li>
        <li><a href="reservering.php">reserveringbeheer</a></li>
        <li><a href="Account_admin.php">accountbeheer</a></li>
      </ul>
      <a href="Account_admin.html">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main>
    <h2>bestaande films</h2>
    <?php if (!empty($melding)) echo "<p>$melding</p>"; ?>
    <form method="POST" action="fimlbeheer.php" class="toevoeg-pagina">
      <label for="naam">Filmtitel:</label><br>
      <input type="text" id="naam" name="naam" required><br><br>

      <label for="rating">PEGI Rating:</label><br>
      <input type="number" id="rating" name="rating" min="0" max="18" required><br><br>

      <label for="room">kamernummer:</label><br>
      <input type="number" id="room" name="room"><br><br>

      <label for="seats">stoelen:</label><br>
      <input type="number" id="seats" name="seats" required><br><br>

      <label for="foto_url">Afbeeldingslink:</label><br>
      <input type="url" id="foto_url" name="foto_url"><br><br>


      <input type="submit" value="Voeg toe">
    </form>

<h2>voeg een film toe</h2>
<section class="film-lijst">
  <?php foreach ($films as $film): ?>
    <section class="film-item">
      <p><?= htmlspecialchars($film['naam']) ?></p>
      <p><?= htmlspecialchars($film['rating']) ?></p>
      <form method="POST" action="fimlbeheer.php" onsubmit="return confirm('Weet je zeker dat je deze film wilt verwijderen?');">
        <input type="hidden" name="verwijder_id" value="<?= $film['naam'] ?>">
        <button type="submit">Verwijder</button>
      </form>
        <?php if (!empty($film['foto_url'])): ?>
  <img src="<?= htmlspecialchars($film['foto_url']) ?>" alt="Filmfoto" style="width: 100px; height: auto;">
<?php endif; ?>
  </section>
  <?php endforeach; ?>
  </section>

</body>
</html>

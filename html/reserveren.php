<?php
session_start();

$host = 'localhost';
$db   = 'mbocinema';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $user, $pass, $options);

$filmnaam = $_POST['film'] ?? ($_GET['film'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $locatie   = $_POST['locatie'] ?? '';
    $datum     = $_POST['datum'] ?? '';
    $tijd      = $_POST['tijd'] ?? '';
    $aantal    = $_POST['aantal'] ?? 1;
    $naam      = $_POST['naam'] ?? '';
    $email     = $_POST['email'] ?? '';
    $telefoon  = $_POST['telefoon'] ?? '';
    $user_id   = $_SESSION["user_id"] ?? null;

    $checkStmt = $pdo->prepare("SELECT seats FROM movies WHERE naam = ?");
    $checkStmt->execute([$filmnaam]);
    $availableSeats = $checkStmt->fetchColumn();

    if ($availableSeats !== false && $availableSeats >= $aantal) {
        $stmt = $pdo->prepare("INSERT INTO reserveringen (locatie, datum, tijd, aantal, naam, email, telefoon, film, user_id) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$locatie, $datum, $tijd, $aantal, $naam, $email, $telefoon, $filmnaam, $user_id]);

        $updateStmt = $pdo->prepare("UPDATE movies SET seats = seats - ? WHERE naam = ?");
        $updateStmt->execute([$aantal, $filmnaam]);

        echo "<script>alert('Reservering opgeslagen!'); window.location.href='films.php';</script>";
        exit;
    } else {
        echo "<script>alert('Niet genoeg stoelen beschikbaar voor deze film.'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Mbo Cinema Reserveren</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <script src="javascript/afhaak.js" defer></script>
</head>
<body class="reserveren-page">
  <section class="container">
    <section class="form-wrapper">
      <section class="form-header">
        <a href="index.php" class="home-icon">
          <img src="fotos/home.png" alt="Home">
        </a>
      </section>

      <h1>Mbo Cinema</h1>
      <form method="post">
        <input type="text" name="film" value="<?= htmlspecialchars($filmnaam) ?>" readonly>
        <input type="text" name="naam" placeholder="Voor en Achternaam" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="telefoon" placeholder="Telefoonnummer" required>
        <input type="text" name="locatie" placeholder="Locatie" required>
        <input type="date" name="datum" required>
        <input type="time" name="tijd" required>
        <input type="number" name="aantal" placeholder="Aantal kaartjes" min="1" required>
        <button type="submit">Next</button>
      </form>
    </section>
  </section>
</body>
</html>

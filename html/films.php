<?php
// --- films.php ---
// Databaseconnectie + AJAX-response
$host = 'localhost';
$db   = 'mbocinema';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connectie mislukt: " . $e->getMessage());
}

// AJAX-handler
if (isset($_GET['q'])) {
    $zoekTerm = $_GET['q'];
    $stmt = $pdo->prepare("SELECT naam, rating FROM movies WHERE naam LIKE :zoek");
    $stmt->execute(['zoek' => '%' . $zoekTerm . '%']);
    $films = $stmt->fetchAll();
    header('Content-Type: application/json');
    echo json_encode($films);
    exit;
}

// Films ophalen voor statische weergave
$stmt = $pdo->query("SELECT naam, rating, room, seats FROM movies LIMIT 20");
$alleFilms = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Mbo Cinema</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src="javascript/zoekfunctie.js" defer></script>
  <link rel="icon" href="fotos/logo.png" type="image/x-icon">
</head>
<body>

<div class="zoek-wrapper">
  <input type="text" id="zoekInput" placeholder="Zoek een film..." autocomplete="off">
  <div id="zoekResultaten"></div>
</div>

<header>
  <nav>
    <a href="index.php" class="logo">Mbo Cinema</a>
    <ul>
      <li><a href="films.php">films</a></li>
      <li><a href="Mijn_Films.html">Mijn Films</a></li>
    </ul>
    <a href="Account_admin.html">
      <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
    </a>
  </nav>
</header>

<main class="films-page">
  <section class="banner">
    <img src="fotos/banner.png" alt="bioscoop banner">
    <h1>Mbo Cinema</h1>
  </section>

  <section class="film-grid" id="filmGrid">
    <?php foreach ($alleFilms as $film): ?>
      <article class="film-card">
        <p><?= htmlspecialchars($film['naam']) ?></p>
        <p><?= htmlspecialchars($film['rating']) ?></p>
        <p><?= htmlspecialchars($film['room']) ?></p>
        <p><?= htmlspecialchars($film['seats']) ?></p>
    </article>
    <?php endforeach; ?>
  </section>
</main>

</body>
</html>

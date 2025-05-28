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
  <script src="javascript/stijl.js"></script>
</head>
<body>
 
<div class="zoek-wrapper">
  <input type="text" id="zoekInput" placeholder="Zoek een film..." autocomplete="off">
  <div id="zoekResultaten"></div>
</div>

  <header>
    <nav>
      <a href="index.html" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="films.php">films</a></li>
        <li><a href="Mijn_Films.html">Mijn Films</a></li>
      </ul>
      <a href="Account_admin.html">
        <img src="fotos/profielfoto.webp" alt="profielfoto"  class="topbar">
      </a>
    </nav>
  </header>

  <main class="films-page">
    <section class="banner">
      <img src="fotos/banner.png" alt="bioscoop banner">
      <h1>Mbo Cinema</h1>
    </section>

    <section class="film-grid" id="filmGrid">
      <div class="film-card">
        <img src="fotos/shang-chi.png" alt="Film afbeelding">
        <p>shang-chi and the legend of the ten rings</p>
      </div>
      <div class="film-card">
        <img src="fotos/dinopark.png" alt="Film afbeelding">
        <p>Jurassic park</p>
      </div>
      <div class="film-card">
        <img src="fotos/inception.png" alt="Film afbeelding">
        <p>Inception</p>
      </div>
      <div class="film-card">
        <img src="fotos/borderlands.png" alt="Film afbeelding">
        <p>Borderlands</p>
      </div>
      <div class="film-card">
        <img src="fotos/batman.png" alt="Film afbeelding">
        <p>The dark knight</p>
      </div>
      <div class="film-card">
        <img src="fotos/redemption.png" alt="Film afbeelding">
        <p>The shawshank redemption</p>
      </div>
      <div class="film-card">
        <img src="fotos/starwars.png" alt="Film afbeelding">
        <p>Star wars a new hope</p>
      </div>
      <div class="film-card">
        <img src="fotos/titanic.png" alt="Film afbeelding">
        <p>Titanic</p>
      </div>
    </section>
  </main>


</body>
</html>



  <script src="javascript/zoekfunctie.js"></script>
</body>
</html>

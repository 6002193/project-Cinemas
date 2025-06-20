<?php
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

// Verwijder reservering
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Eerst het aantal kaartjes ophalen en bijbehorende filmnaam
    $stmt = $pdo->prepare("SELECT film, aantal FROM reserveringen WHERE id = ?");
    $stmt->execute([$deleteId]);
    $reservering = $stmt->fetch();

    if ($reservering) {
        $filmNaam = $reservering['film'];
        $aantalKaartjes = $reservering['aantal'];

        // Stoelen terugzetten
        $update = $pdo->prepare("UPDATE movies SET seats = seats + ? WHERE naam = ?");
        $update->execute([$aantalKaartjes, $filmNaam]);

        // Reservering verwijderen
        $del = $pdo->prepare("DELETE FROM reserveringen WHERE id = ?");
        $del->execute([$deleteId]);
        

    }

    // Herlaad om dubbele POST te voorkomen
    header("Location: reservering.php");
    exit;
}

// Reserveringen ophalen
$stmt = $pdo->query("SELECT * FROM reserveringen ORDER BY datum DESC, tijd DESC");
$reserveringen = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Een korte omschrijving van je website die in zoekmachines verschijnt.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="Movie, MboCinemas, MovieTheatre">
  <meta name="author" content="Jelle Groen">
  <meta charset="UTF-8">
  <title>Mbo Cinema - Reserveringen</title>
 <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/reserve.css">
  <script src="javascript/afhaak.js" defer></script>


</head>
<body>
  <header>
    <nav>
      <a href="index.php" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="fimlbeheer.php">filmbeheer</a></li>
        <li><a href="zaalbeheer.php">zaalbeheer</a></li>
        <li><a href="">reserveringbeheer</a></li>
        <li><a href="accounts.php">accountbeheer</a></li>
      </ul>
      <a href="Inloggen.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main class="reservering-overzicht">
    <h1>Alle Reserveringen</h1>
    <?php if (!empty($reserveringen)): ?>
      <table class="reservering-tabel">
        <thead>
          <tr>
            <th>Naam</th>
            <th>Email</th>
            <th>Telefoon</th>
            <th>Film</th>
            <th>Locatie</th>
            <th>Datum</th>
            <th>Tijd</th>
            <th>Aantal</th>
            <th>Actie</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reserveringen as $res): ?>
            <tr>
              <td><?= htmlspecialchars($res['naam']) ?></td>
              <td><?= htmlspecialchars($res['email']) ?></td>
              <td><?= htmlspecialchars($res['telefoon']) ?></td>
              <td><?= htmlspecialchars($res['film']) ?></td>
              <td><?= htmlspecialchars($res['locatie']) ?></td>
              <td><?= htmlspecialchars($res['datum']) ?></td>
              <td><?= htmlspecialchars($res['tijd']) ?></td>
              <td><?= htmlspecialchars($res['aantal']) ?></td>
              <td>
                <form method="post" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                  <input type="hidden" name="delete_id" value="<?= $res['id'] ?>">
                  <button type="submit">Verwijder</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Er zijn nog geen reserveringen.</p>
    <?php endif; ?>
  </main>
</body>

</html>
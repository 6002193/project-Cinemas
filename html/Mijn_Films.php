<?php
session_start();

// Databaseverbinding instellen
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

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}

// Check of gebruiker is ingelogd
if (empty($_SESSION["user_id"])) {
    header("Location: inloggen.php");
    exit;
}

// Verwijderen van reservering als formulier verzonden is
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reservering_id'])) {
    $deleteId = $_POST['delete_reservering_id'];
    try {
        // Eerst ophalen van film en aantal tickets uit de reservering
        $stmt = $pdo->prepare("SELECT film, aantal FROM reserveringen WHERE id = ? AND user_id = ?");
        $stmt->execute([$deleteId, $_SESSION["user_id"]]);
        $reservering = $stmt->fetch();

        if ($reservering) {
            $filmNaam = $reservering['film'];
            $aantalTickets = (int)$reservering['aantal'];

            // Update tickets beschikbaar in de films tabel
            $updateStmt = $pdo->prepare("UPDATE movies SET seats = seats + ? WHERE naam = ?");
            $updateStmt->execute([$aantalTickets, $filmNaam]);

            // Verwijder de reservering
            $deleteStmt = $pdo->prepare("DELETE FROM reserveringen WHERE id = ? AND user_id = ?");
            $deleteStmt->execute([$deleteId, $_SESSION["user_id"]]);
        }
    } catch (PDOException $e) {
        die("Databasefout bij verwijderen: " . $e->getMessage());
    }
}

// Reserveringen ophalen
$reserveringen = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM reserveringen WHERE user_id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $reserveringen = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mijn Films</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/mijn_reserveringen.css" />
</head>
<body>

<header>
    <nav>
        <a href="index.php" class="logo">Mbo Cinema</a>
        <ul>
            <li><a href="films.php">Films</a></li>
            <li><a href="Mijn_Films.php">Mijn Films</a></li>
            <li><a href="account_admin.php">Account</a></li>
        </ul>
        <a href="inloggen.php">
            <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar" />
        </a>
    </nav>
</header>
<main class="container mijn-films-container">
    <h2>Welkom, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>

    <?php if (count($reserveringen) > 0): ?>
        <h3>Jouw reserveringen:</h3>
        <table>
            <thead>
                <tr>
                    <th>Film</th>
                    <th>Locatie</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Aantal</th>
                    <th>Gereserveerd op</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reserveringen as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['film']) ?></td>
                        <td><?= htmlspecialchars($res['locatie']) ?></td>
                        <td><?= htmlspecialchars($res['datum']) ?></td>
                        <td><?= htmlspecialchars($res['tijd']) ?></td>
                        <td><?= htmlspecialchars($res['aantal']) ?></td>
                        <td><?= htmlspecialchars($res['created_at']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                                <input type="hidden" name="delete_reservering_id" value="<?= $res['id'] ?>" />
                                <button type="submit" class="delete-btn">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Je hebt nog geen reserveringen gemaakt.</p>
    <?php endif; ?>
</main>

</body>
</html>

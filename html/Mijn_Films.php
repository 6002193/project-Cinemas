<?php
session_start();

// Databaseverbinding
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

// Reservering aanpassen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'], $_POST['res_id'])) {
    $id     = $_POST['res_id'];
    $loc    = $_POST['locatie'];
    $datum  = $_POST['datum'];
    $tijd   = $_POST['tijd'];
    $aantal = $_POST['aantal'];

    $stmt = $pdo->prepare("UPDATE reserveringen SET locatie = ?, datum = ?, tijd = ?, aantal = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$loc, $datum, $tijd, $aantal, $id, $_SESSION["user_id"]]);

    header("Location: Mijn_Films.php");
    exit;
}

// Verwijderen van reservering
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reservering_id'])) {
    $deleteId = $_POST['delete_reservering_id'];
    try {
        $stmt = $pdo->prepare("SELECT film, aantal FROM reserveringen WHERE id = ? AND user_id = ?");
        $stmt->execute([$deleteId, $_SESSION["user_id"]]);
        $reservering = $stmt->fetch();

        if ($reservering) {
            $updateStmt = $pdo->prepare("UPDATE movies SET seats = seats + ? WHERE naam = ?");
            $updateStmt->execute([(int)$reservering['aantal'], $reservering['film']]);

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
    $stmt = $pdo->prepare("SELECT id, film, locatie, datum, tijd, aantal, created_at, bevestigingsnummer FROM reserveringen WHERE user_id = ?");
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
        <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet" />
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
                    <th>Bevestigingsnummer</th>
                    <th>Locatie</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Aantal</th>
                    <th>Gereserveerd op</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reserveringen as $res): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="res_id" value="<?= $res['id'] ?>">
                            <?php if (isset($_POST['edit']) && $_POST['res_id'] == $res['id']): ?>
                                <td><?= htmlspecialchars($res['film']) ?></td>
                                <td><?= htmlspecialchars($res['bevestigingsnummer']) ?></td>
                                <td><input type="text" name="locatie" value="<?= htmlspecialchars($res['locatie']) ?>"></td>
                                <td><input type="date" name="datum" value="<?= htmlspecialchars($res['datum']) ?>"></td>
                                <td><input type="time" name="tijd" value="<?= htmlspecialchars($res['tijd']) ?>"></td>
                                <td><input type="number" name="aantal" value="<?= htmlspecialchars($res['aantal']) ?>" min="1"></td>
                                <td><?= htmlspecialchars($res['created_at']) ?></td>
                                <td><button type="submit" name="save">Opslaan</button></td>
                            <?php else: ?>
                                <td><?= htmlspecialchars($res['film']) ?></td>
                                <td><?= htmlspecialchars($res['bevestigingsnummer']) ?></td>
                                <td><?= htmlspecialchars($res['locatie']) ?></td>
                                <td><?= htmlspecialchars($res['datum']) ?></td>
                                <td><?= htmlspecialchars($res['tijd']) ?></td>
                                <td><?= htmlspecialchars($res['aantal']) ?></td>
                                <td><?= htmlspecialchars($res['created_at']) ?></td>
                                <td>
                                    <button type="submit" name="edit">Bewerk</button>
                                    <button type="submit" name="delete_reservering_id" value="<?= $res['id'] ?>" onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">Verwijder</button>
                                </td>
                            <?php endif; ?>
                        </form>
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

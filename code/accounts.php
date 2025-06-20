<?php
session_start();

// Database connectie
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
    die("Database verbinding mislukt: " . $e->getMessage());
}

// Verwijder account als delete_id wordt meegegeven via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];

    // Eerst reserveringen verwijderen
    $stmt = $pdo->prepare("DELETE FROM reserveringen WHERE user_id = ?");
    $stmt->execute([$deleteId]);

    // Daarna gebruiker verwijderen
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$deleteId]);

    header("Location: accounts.php");
    exit;
}

// Alle accounts ophalen
$stmt = $pdo->query("SELECT id, UserName, email, telefoonnumer FROM users ORDER BY UserName ASC");
$accounts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Accounts Overzicht</title>
        <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mijn_reserveringen.css"> 

</head>
<body class="accounts-page">
  <header>
    <nav>
      <a href="index.php" class="logo">Mbo Cinema</a>
            <ul>
        <li><a href="fimlbeheer.php">filmbeheer</a></li>
        <li><a href="">zaalbeheer</a></li>
        <li><a href="reservering.php">reserveringbeheer</a></li>
        <li><a href="accounts.php">accountbeheer</a></li>
      </ul>
      <a href="Account_admin.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main>
    <h1 style="text-align:center;">Accounts Overzicht</h1>

    <?php if (count($accounts) === 0): ?>
        <p style="text-align:center;">Er zijn nog geen accounts.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Gebruikersnaam</th>
                    <th>Email</th>
                    <th>Telefoonnummer</th>
                    <th>Actie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                    <tr>
                        <td><?= htmlspecialchars($account['UserName']) ?></td>
                        <td><?= htmlspecialchars($account['email']) ?></td>
                        <td><?= htmlspecialchars($account['telefoonnumer']) ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Weet je zeker dat je dit account wilt verwijderen?');">
                                <input type="hidden" name="delete_id" value="<?= $account['id'] ?>">
                                <button type="submit" class="delete-btn">Verwijder</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
  </main>
</body>
</html>

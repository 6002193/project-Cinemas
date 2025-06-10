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

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

// Voorbeeld user_id ophalen uit sessie (pas aan indien nodig)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // Niet ingelogd, doorverwijzen naar loginpagina
    header("Location: Inloggen.php");
    exit;
}

// Update verwerking
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['field'], $_POST['value'])) {
    $validFields = ['UserName', 'UserPassword', 'email', 'telefoonnumer'];
    $field = $_POST['field'];
    $value = trim($_POST['value']);

    if (in_array($field, $validFields)) {
        if ($field === 'UserPassword') {
            // Hash het wachtwoord
            $value = password_hash($value, PASSWORD_DEFAULT);
        }
        $stmt = $pdo->prepare("UPDATE users SET $field = ? WHERE id = ?");
        $stmt->execute([$value, $user_id]);
        $message = ucfirst($field) . " is succesvol bijgewerkt!";
    } else {
        $message = "Ongeldig veld.";
    }
}

// Gegevens ophalen om te tonen in het formulier (geen wachtwoord tonen)
$stmt = $pdo->prepare("SELECT UserName, email, telefoonnumer FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch();

if (!$userData) {
    die("Gebruiker niet gevonden.");
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account aanpassen - Mbo Cinema</title>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="fotos/logo.png" type="image/x-icon" />
</head>

<body class="account-pagina">
    <header>
        <nav>
            <a href="index.php" class="logo">Mbo Cinema</a>
            <ul>
                <li><a href="films.php">Films</a></li>
                <li><a href="Mijn_Films.php">Mijn Films</a></li>
                <li><a href="account_admin.php">Account</a></li>
            </ul>
            <a href="Account_admin.php">
                <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar" />
            </a>
        </nav>
    </header>

    <main class="settings-container">
        <div class="settings-card">

            <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="content">

                <!-- Naam aanpassen -->
                <div class="row">
                    <span>Naam</span>
                    <form method="post" class="inline-form">
                        <input type="hidden" name="field" value="UserName" />
                        <input type="text" name="value" value="<?= htmlspecialchars($userData['UserName']) ?>" required />
                        <button type="submit">Verander</button>
                    </form>
                </div>

                <!-- Wachtwoord aanpassen -->
                <div class="row">
                    <span>Wachtwoord</span>
                    <form method="post" class="inline-form">
                        <input type="hidden" name="field" value="UserPassword" />
                        <input type="password" name="value" placeholder="Nieuw wachtwoord" required />
                        <button type="submit">Verander</button>
                    </form>
                </div>

                <!-- Email aanpassen -->
                <div class="row">
                    <span>Email</span>
                    <form method="post" class="inline-form">
                        <input type="hidden" name="field" value="email" />
                        <input type="email" name="value" value="<?= htmlspecialchars($userData['email']) ?>" required />
                        <button type="submit">Verander</button>
                    </form>
                </div>

                <!-- Telefoonnummer aanpassen -->
                <div class="row">
                    <span>Telefoonnummer</span>
                    <form method="post" class="inline-form">
                        <input type="hidden" name="field" value="telefoonnumer" />
                        <input type="text" name="value" value="<?= htmlspecialchars($userData['telefoonnumer']) ?>" required />
                        <button type="submit">Verander</button>
                    </form>
                </div>

            </div>
        </div>
    </main>
</body>

</html>

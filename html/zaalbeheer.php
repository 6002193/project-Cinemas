<?php
// === Room update verwerken ===
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_room'])) {
    $movie_id = intval($_POST['movie_id']);
    $new_room = intval($_POST['new_room']);

    $mysqli = new mysqli("localhost", "root", "", "mbocinema");
    if (!$mysqli->connect_error) {
        $stmt = $mysqli->prepare("UPDATE movies SET room = ? WHERE id = ?");

        $stmt->bind_param("ii", $new_room, $movie_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']); // Herlaad pagina na update
        exit();
    }
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
</head>
<body>
  <header>
    <nav>
           <a href="index.php" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="fimlbeheer.php">filmbeheer</a></li>
        <li><a href="">zaalbeheer</a></li>
        <li><a href="reservering.php">reserveringbeheer</a></li>
        <li><a href="Account_admin.php">accountbeheer</a></li>
      </ul>
      <a href="Inloggen.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <?php
  // Verbind met de database
  $mysqli = new mysqli("localhost", "root", "", "mbocinema");

  if ($mysqli->connect_errno) {
      echo "<p style='color:red; text-align:center;'>Databasefout: " . $mysqli->connect_error . "</p>";
      exit();
  }

  $sql = "SELECT id, naam, rating, room, seats FROM movies WHERE room IS NOT NULL";
  $result = $mysqli->query($sql);
  ?>

  <article class="film-container">
    <h1>Beschikbare Films met Zaal</h1>

    <?php if ($result && $result->num_rows > 0): ?>
      <table class="film-tabel">
        <thead>
          <tr>
            <th>Naam</th>
            <th>Rating</th>
            <th>Zaal</th>
            <th class="seats">Stoelen</th>
            <th>Wijzig zaal</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($film = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($film['naam']) ?></td>
              <td><?= htmlspecialchars($film['rating']) ?></td>
              <td><?= htmlspecialchars($film['room']) ?></td>
              <td class="seats"><?= htmlspecialchars($film['seats']) ?></td>
              <td>
                <form method="POST" class="zaal-form">
                  <input type="hidden" name="movie_id" value="<?= $film['id'] ?>">
                  <input type="number" name="new_room" placeholder="Nieuw zaalnr" required>
                  <button type="submit" name="change_room">Wijzig</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Er zijn momenteel geen films met een gekoppelde zaal.</p>
    <?php endif; ?>
  </article>
</body>
</html>

<?php
session_start();

if (empty($_SESSION["username"])):
  header("Location: inloggen.php");
  exit;
endif
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
  <link rel="icon" href="fotos/logo.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="background">
  <header>
    <nav>
      <a href="<?= (!empty($_SESSION['admin']) && $_SESSION['admin'] == 1) ? 'fimlbeheer.php' : '#' ?>" class="logo"
        <?= (empty($_SESSION['admin']) || $_SESSION['admin'] != 1) ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
        Mbo Cinema
      </a>

      <ul>
        <li><a href="films.php">Films</a></li>
        <li><a href="Mijn_Films.php">Mijn Films</a></li>
        <li><a href="account_admin.php">Account</a></li>
      </ul>
      <a href="Inloggen.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto" class="topbar">
      </a>
    </nav>
  </header>

  <main>
    <section class="intro">
      <p>
        <?php if (!empty($_SESSION["username"])): ?>
        <h2>Hallo <?= htmlspecialchars($_SESSION["username"]) ?>.<br></h2>
      <?php endif; ?>

      Welkom bij Mbo Cinema. Jouw filmervaring begint hier.<br>
      Stap binnen in de wereld van film! Bij Mbo Cinema beleef je de nieuwste,
      meeslepende arthousefilms en tijdloze klassiekers in een comfortabele
      en moderne setting. Geniet van de ultieme bioscoopervaring met haarscherp
      beeld, krachtig geluid en de beste service. Ontdek ons actuele programma,
      koop eenvoudig je tickets online en laat je verrassen door film zoals het bedoeld is.
      </p>
    </section>

    <section class="poster">
      <img src="fotos/Shang-Chi.png" alt="Shang-Chi poster">
      <a href="films.php" class="button-link">Films die nu draaien</a>
    </section>
  </main>
</body>

</html>
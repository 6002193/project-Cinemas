<!DOCTYPE httml>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <!--Zorgt ervoor dat de pagina correct word weergegeven op mobiele apparaten.-->
    <meta name="viewport" content="width=device-width, initial-scale=1,0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--SEO (search engen optimation) Metagegevens -->
    <!-- Descripption voor zoekmachines en sociale media, omschrijft kort de inhoud van de pagina-->
    <meta name="description" content="Een korte beschrijfing van de pagina.">
    <!-- Keywords Helpt zoekmachines begrijpen waar de pagina over gaat. -->
    <meta name="Keywords" content="html, meta tags, voorbeeld, webontwikkeling">
    <!-- Author de naam van de developer van de pagina. -->
    <meta name="author" content="Tijs Vreijling">

    <title>MBO Cinema Inlogen</title>
    <!-- Favicon kleine afbeelding die wordt weergegeven in de browser-tabbladen -->
    <link rel="icon" href="fotos/logo.php" type="image/x-icon">
    <!-- link naar de stylesheet-->
    <link rel="stylesheet" href="css/style.css">
    <!-- link naar de google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <!-- link naar de javaSchript pagina-->
    <script src="" defer></script>
</head>

<body>
   <header>
    <nav>
          <a href="index.php" class="logo">Mbo Cinema</a>
      <ul>
        <li><a href="films.php">films</a></li>
        <li><a href="Mijn_Films.html">Mijn Films</a></li>
      </ul>
      <a href="Inloggen.php">
        <img src="fotos/profielfoto.webp" alt="profielfoto"  class="topbar" >
      </a>
    </nav>
  </header>
    <main>
        <row1 class="row1">
            <img class="inlogfilm" src="fotos/shang-chi.png" alt="Film afbeelding">
            <img class="inlogfilm" src="fotos/shang-chi.png" alt="Film afbeelding">

        </row1>
        <row2 class="row2">
            <img class="inlogfilm" src="fotos/shang-chi.png" alt="Film afbeelding">
            <img class="inlogfilm" src="fotos/shang-chi.png" alt="Film afbeelding">

        </row2>

        <form action="/action_page.php" method="post">
            <div class="imgcontainer">
                <img src="fotos/profielfoto.webp" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label for="eml"><b>email</b></label>
                <input type="email" placeholder="Enter email" name="eml" required>

                <label for="tel"><b>telefoonnummer</b></label>
                <input type="tel" placeholder="Enter Telephone number" name="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>

                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <!-- <div class="container">
                <button type="button" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="Account_admin.html" class="psw">password?</a></span> -->
            </div>
        </form>
    </main>
    <footer>
    </footer>
</body>
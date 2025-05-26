<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mbo Cinema Inloggen</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
  <div class="container">
    <div class="column image-column">
      <img src="fotos/batman.png" alt="Cinema">
      <img src="fotos/borderlands.png" alt="Cinema">
    </div>
    <div class="column form-column">
      <h1>Mbo Cinema</h1>
      <h2>Inloggen</h2>
      <form action="login.php" method="post">
        <label>Username</label>
        <input type="text" name="name" placeholder="Username">

        <label>Email</label>
        <input type="email" name="email" placeholder="Voorbeeld@email.com">

        <label>Wachtwoord</label>
        <input type="password" name="password" placeholder="Password">


        <button type="submit">Klaar</button>
      </form>
    </div>
    <div class="column image-column">
      <img src="fotos/dinopark.png" alt="Cinema">
      <img src="fotos/inception.png" alt="Cinema">
    </div>
  </div>
</body>

</html>

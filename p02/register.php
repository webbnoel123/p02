<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="register">
      <h1>Slöseribanken</h1>
      <h2>Registrera dig</h2>
      <form class="register-form" action="action/insert_user.php" method="post">
        <label for="username">username</label><br>
        <input class="text-input" type="text" name="username" required><br><br>
        <label for="firstname">Förnamn</label><br>
        <input class="text-input" type="text" name="firstname" required><br><br>
        <label for="lastname">Efternamn</label><br>
        <input class="text-input" type="text" name="lastname" required><br><br>
        <label for="password">Lösenord</label><br>
        <input class="text-input" type="password" name="password" required><br><br>
        <label for="password">Repetera lösenord</label><br>
        <input class="text-input" type="password" name="repeat_password" required><br><br>
        <input class="submit-input"type="submit" name="register" value="Registrera dig">
      </form>
      <br><a class="login" href="index.php">Har du konto, logga in</a>
    </div>
  </body>
</html>

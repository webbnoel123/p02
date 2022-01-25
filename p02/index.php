<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="login">
      <h1>Slöseribanken</h1>
      <h2>Logga in</h2>
      <form class="login-form" action="user/index.php" method="post">
        <label for="login_key">Användarnamn</label><br>
        <input class="text-input" type="text" name="login_key" required><br><br>
        <label for="password">Lösenord</label><br>
        <input class="text-input" type="password" name="password" required><br><br>
        <input class="submit-input" type="submit" name="login" value="Logga in">
      </form>
      <br><a class="register" href="register.php">Har du inget konto, registrera dig</a><br><br>
      <?php
        if (isset($_GET['mess'])) {
          echo $_GET['mess'];
        }
       ?>
    </div>
  </body>
</html>

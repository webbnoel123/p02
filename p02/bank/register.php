<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>slöseribanken</h1>
    <form class="login" action="bank/functions/register_user.php" method="post">
      <input type="text" name="username" placeholder="användarnamn">
      <input type="password" name="password" placeholder="lösenord">
      <input type="password" name="repeat_password" placeholder="repetera lösenord">
      <input type="submit" name="register" value="registrera dig"><br>
    </form>
    <?php
      header('Cache-Control: no cache');
      if (isset($_GET['mess'])) {
        echo "<p style='color: red'>".$_GET['mess']."</p>";
      }
     ?>
  </body>
</html>

<?php
  header('Cache-Control: no cache');
  session_start();

  if (isset($_POST['login_key']) and isset($_POST['password'])) {
    $_SESSION['login_key'] = $_POST['login_key'];
    $_SESSION['password'] = $_POST['password'];
  } #kollar om användaren finns i post
  else if (!isset($_SESSION['login_key'])) {
    header("Location: ../");
  } #kollar om användaren finns i session annars skickar vi tillbaka den till logga in
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
   <link rel="stylesheet" href="../style.css">
 </head>
 <body style="width:30%; margin:0 auto;">
   <h2>Slöseribanken</h2>
   <a href="index.php" style="float:right;">Tillbaka</a>
   <div class="create-account">
     <span>Skapa nytt konto</span>
     <form class="create-account-form" action="../action/insert_account.php" method="post">
       <label for="account-name">Konto namn</label>
       <input type="text" name="account_name">
       <input type="submit" name="submit_new_account" value="Skapa konto">
     </form>
     <?php
       if (isset($_GET['mess'])) {
         echo $_GET['mess'];
       }
      ?>
   </div>
 </body>
</html>

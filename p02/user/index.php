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

  require_once("../func/db_connect.php");
  require_once("../func/check_login.php");
  require_once("../func/get_transactions.php");
  require_once("../func/get_accounts.php");
  require_once("../func/get_balance.php");
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
   <link rel="stylesheet" href="../style.css">
 </head>
 <body>
   <div class="user">
     <h2>Slöseribanken</h2>
     <span>Konton</span>
     <div class="accounts">
       <?php
        foreach(get_accounts($res['user_id'], $pdo) as $account) {
          echo '<a href="account.php?account='.$account["account_id"].'" class="account">';
          echo '<span class="account-name">'.$account["account_name"].'</span>';
          echo '<span class="account-balance">'.get_balance($account["account_id"], $pdo)."kr".'</span>';
          echo '</a>';
        }
        ?>
     </div>

     <a href="create_account.php">Skapa nytt konto</a>
     <a href="../action/log_out.php" style="float:right;">Logga ut</a>
     <?php
       if (isset($_GET['mess'])) {
         echo $_GET['mess'];
       }
      ?>
   </div>
 </body>
</html>

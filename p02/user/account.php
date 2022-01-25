<?php
  header('Cache-Control: no cache');
  session_start();

  if (!isset($_SESSION['login_key'])) {
    header("Location: ../");
  } #kollar om användaren finns i session annars skickar vi tillbaka den till logga in

  require_once("../func/db_connect.php");
  require_once("../func/check_login.php");
  require_once("../func/get_transactions.php");
  require_once("../func/get_accounts.php");
  require_once("../func/get_balance.php");
  require_once("../func/get_account_name.php");

  $account_id = $_GET['account'];
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
    <div style="width:30%; margin: 0 auto;">
      <h2>Slöseribanken</h2>
      <a id="switch" style="cursor:pointer;" onclick="switch_();">Gör en transaktion</a>
      <a href="index.php" style="float:right;">Tillbaka</a>
      <div class="account-transactions" id="side1">
     <div class="account-info">
       <?php
        echo '<span class="account-info-name">'.get_account_name($account_id, $pdo).'</span>';
        echo '<br><br>';
        echo '<span class="account-info-balance">Saldo: '.get_balance($account_id, $pdo).'kr</span>';
        ?>
     </div>
     <div class="transactions">
       <?php
        foreach(get_transactions($account_id, $pdo) as $transaction) {
          echo '<div class="transaction">';
          echo '<span class="transaction-info">'.$transaction["info"].'</span>';
          echo '<span class="transaction-amount">'.$transaction["amount"].'kr</span>';
          echo '<br><br>';
          echo '<span class="transaction-date">'.$transaction["transaction_date"].'</span>';
          echo '</div>';
        }
        ?>
     </div>
   </div>
      <div class="transact" id="side0" style="display:none">
        <?php
       if (isset($_GET['mess'])) {
         echo $_GET['mess'];
       }
      ?>
      <div class="make_transaction" style=" margin-top: 20px; padding-top: 20px;">
       <h4>Överför</h4>
       <form action="../func/transaction.php" method="post">
         <label for="recipient">Mottagare (användarnamn)</label>
         <input type="text" name="recipient" required>
         <label for="amount">Summa</label>
         <input type="text" name="amount" required>
         <input type="submit" name="transact" value="Överför">
         <?php
          echo '<input type="hidden" name="account" value="'.$account_id.'">';
          ?>

       </form>
       <form action="../func/transaction.php" method="post">
         <select class="recipient_account_id" name="recipient_account_id" style="color:white;" required>
           <option disabled selected>Välj konto</option>
           <?php
            foreach(get_accounts($res['user_id'], $pdo) as $account) {
              if ($account["account_id"] != $account_id) {
                echo '<option value="'.$account["account_id"].'">'.$account["account_name"].'</option>';
              }
            }
            ?>
         </select>
         <label for="amount" required>Summa</label>
         <input type="text" name="amount" required>
         <input type="submit" name="transact" value="Överför">
         <?php
          echo '<input type="hidden" name="account" value="'.$account_id.'">'
          ?>
       </form>
      </div>
      <div class="deposit" style="border-top:1px solid white; margin-top: 20px; padding-top: 20px;">
       <h4>Gör en instättning</h4>
       <form action="../func/deposit.php" method="post">
         <label for="amount">Summa</label required>
         <input type="text" name="amount" required>
         <input type="submit" name="deposit" value="Sätt in">
         <?php
          echo '<input type="hidden" name="account" value="'.$account_id.'">'
          ?>
        </form>
      </div>
    </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  var side = 1;
  function switch_() {
    if (side) {
      side = 0;
      document.getElementById("switch").innerHTML = "Översikt";
      document.getElementById("side1").style.display = "none";
      document.getElementById("side0").style.display = "block";
    } else {
      side = 1;
      document.getElementById("switch").innerHTML = "Gör en transaktion";
      document.getElementById("side1").style.display = "block";
      document.getElementById("side0").style.display = "none";
    }
  }
</script>

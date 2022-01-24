<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <?php

      include('functions/redirect.php');
      include('functions/check_user_info.php');
      include('functions/get_account_info.php');

      session_start();

      if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
          session_unset();
          session_destroy();
          redirect('../', 'du har varit borta i längre än 5 minuter och har därför blivit utloggad');
      }
      $_SESSION['LAST_ACTIVITY'] = time();

      if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
      } else {
        redirect('../');
      }

      if (isset($_GET['account']) and file_exists('../user_info/'.$username.'/'.$_GET['account'].'.txt')) {
        $account = $_GET['account'];
      } else {
        redirect('../bank');
      }

      check_user_info($username, $password);
     ?>
    <h1>slöseribanken</h1>
    <div class="account-overview">
      <div class="account-info">
        <?php
          echo '<h3>'.$account.'</h3>';
          if ($account != 'main') {
            echo '<a href="functions/delete_account.php?account='.$account.'">radera konto</a>';
          }
          echo '<span>'.get_account_id($username, $account).'</span>';
          echo '<span>tillgängligt belopp: '.get_account_balance($username, $account).'kr</span>'
         ?>
      </div>
      <h4>transaktioner</h4>
      <?php
        foreach (get_account_transactions($username, $account) as $transaction) {
          echo '<div class="transaction">';
          echo '<span class="reciever">'.$transaction['reciever'].'</span>';
          echo '<span class="amount">'.$transaction['amount'].'kr</span>';
          echo '<span class="date">'.$transaction['date'].'</span>';
          echo '</div>';
        }
       ?>

    </div>
  </body>
</html>

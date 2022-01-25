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
      include('../functions/redirect.php');
      include('../functions/check_user_info.php');
      include('../functions/get_account_info.php');

      header('Cache-Control: no cache');

      session_start();

      if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300) and !isset($_POST['username'])) {
          session_unset();
          session_destroy();
          redirect('../', 'du har varit borta i längre än 5 minuter och har därför blivit utloggad');
      }
      $_SESSION['LAST_ACTIVITY'] = time();

      if (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $username = $_POST['username'];
        $password = $_POST['password'];
      } else if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
      } else {
        redirect('../');
      }

      check_user_info($username, $password);
     ?>
     <h1>slöseribanken</h1>
     <div class="accounts">
       <h3>konton</h3>
       <?php
         $accounts = get_accounts_by_user($username);
         foreach ($accounts as $account) {
           $account_balance = get_account_balance($username, $account);
           $account_id = get_account_id($username, $account);
           echo '<a href="account.php?account='.$account.'"><span class="account-name">'.$account.'</span><span class="account-balance">'.$account_balance.'kr</span><span class="account-id">'.$account_id.'</span></a>';
         }
        ?>
     </div>
     <button id="transfer-button">överför</button>
     <button id="new-account-button">nytt konto</button>
     <?php
      if (isset($_GET['mess'])) {
        echo "<h4>".$_GET['mess']."</h4>";
      }
      ?>
     <div id="transfer-box" class="transfer-box">
       <div class="transfer-content">
         <span class="transfer-close">&times;</span>
         <form class="transfer" action="transfer.php" method="post">
          <br>
           <h3>överför</h3>
           <select name="sender" id="select-sender">
             <option value="select" id ="select" selected>från</option>
             <?php
               foreach (get_accounts_by_user($username) as $account) {
                 echo '<option value="'.$account.'">'.$account.' - '.get_account_balance($username, $account).'kr</option>';
               }
              ?>
          </select>
          <select name="reciever" id="select-reciever">
            <option value="select" id ="select" selected>till</option>
            <?php
              foreach (get_accounts_by_user($username) as $account) {
                echo '<option value="'.$account.'">'.$account.' - '.get_account_balance($username, $account).'kr</option>';
              }
             ?>
             <option value="other" id ="other">ange kontonummer</option>
         </select>
         <input type="text" name="account-number" placeholder=":" class="account-number" id="account-number">
         <input type="text" name="amount" placeholder="belopp">
         <input type="submit" name="submit-transfer" value="slutför överföring">
         </form>
       </div>
     </div>
     <div id="new-account-box" class="new-account-box">
       <div class="new-account-content">
         <span class="new-account-close">&times;</span>
         <form class="new-account" action="functions/new_account.php" method="post">
           <input type="text" name="account-name" placeholder="konto namn">
           <input type="submit" name="submit-new-account" value="skapa konto">
         </form>
       </div>
    </div>
    <div id="password-box" class="password-box">
      <div class="password-content">
        <span class="password-close">&times;</span>
        <form class="password" action="functions/change_password.php" method="post">
          <input type="password" name="old_password" placeholder="lösenord">
          <input type="password" name="new_password" placeholder="nytt lösenord">
          <input type="password" name="repeat_password" placeholder="repetera lösenord">
          <input type="submit" name="change_password" value="spara">
        </form>
      </div>
   </div>
    <?php
      echo "<br>du är inloggad som ".$username."<br>";
     ?>
    <a href="functions/log_out.php">logga ut</a>
    <br>
    <button id="password-button">byt lösenord</button>
    <script src="script.js"></script>
  </body>
</html>

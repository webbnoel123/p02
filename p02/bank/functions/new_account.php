<?php
  include('get_account_info.php');
  include('redirect.php');
  if (isset($_POST['submit-new-account']) and isset($_POST['account-name'])) {
    session_start();
    if (!isset($_SESSION['username'])) {
      redirect('../', 'error in new_account.php');
    }
    $username = $_SESSION['username'];
    $new_account_name = $_POST['account-name'];
    if (check_legal_account_name($new_account_name) == 0) { redirect('../', 'konto namnet får inte innehålla alla tecken'); }
    if (check_legal_account_name($new_account_name) == -1) { redirect('../', 'konto namnet får inte innehålla fler än 8 tecken'); }
    if (file_exists('../../user_info/'.$username.'/'.$new_account_name.'.txt')) {
      redirect('../', 'kontot finns redan');
    }
    $file = fopen('../../user_info/'.$username.'/'.$new_account_name.'.txt', 'w');
    fwrite($file, '|'.new_account_id($username, $new_account_name));
    fwrite($file, "\n");
    fclose($file);

    redirect('../', 'kontot har skapats');
  }
 ?>

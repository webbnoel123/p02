<?php
  include('redirect.php');
  include('get_account_info.php');
  session_start();
  if (!isset($_SESSION['username']) or !isset($_GET['account'])) {
    redirect('../../');
  }
  $username = $_SESSION['username'];
  $account = $_GET['account'];
  if (!file_exists('../../user_info/'.$username.'/'.$account.'.txt')) { redirect('../../'); }
  if (get_account_balance($username, $account, '../../user_info') > 0) { redirect('../', 'du får inte ha några pengar på kontot om du ska radera det'); }
  unlink('../../user_info/'.$username.'/'.$account.'.txt');
  redirect('../', 'kontot raderat');
 ?>

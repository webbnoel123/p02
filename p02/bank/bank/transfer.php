<?php
  include('functions/redirect.php');
  include('functions/get_account_info.php');
  function transfer($from, $to, $amount) {
    session_start();
    if (!isset($_SESSION['username'])) {
      redirect('../', 'error in transfer.php');
    }


    $username = $_SESSION['username'];

    if (get_account_balance($username, $from) - (int)$amount < 0) {
      redirect('../bank', 'du har inte tillräckligt med pengar');
    }

    if (!str_contains($to, '/')) {
      $to = $username.'/'.$to;
    }

    if ($username.'/'.$from == $to) {
      redirect('../bank', 'du kan inte välja samma konto');
    }

    $file = fopen('../user_info/'.$username.'/'.$from.'.txt', 'a');
    fwrite($file, '-'.$amount.'|'.get_account_id(explode('/', $to)[0], explode('/', $to)[1]).'|'.date('Y-m-d'));
    fwrite($file, "\n");
    fclose($file);

    $file = fopen('../user_info/'.$to.'.txt', 'a');
    fwrite($file, $amount.'|'.get_account_id($username, $from).'|'.date('Y-m-d'));
    fwrite($file, "\n");
    fclose($file);

    redirect('../bank', 'överföring slutförd');

  }
  session_start();
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } else {
    redirect('../bank', 'error in transfer.php');
  }
  if (isset($_POST['submit-transfer'])) {
    if ($_POST['sender'] == 'select' or $_POST['reciever'] == 'select') {redirect('../bank', 'måste välja konto');}
    if (!isset($_POST['amount']) or (int)$_POST['amount'] <= 0) {redirect('../bank', 'ogiltlig summa');}
    if (!account_exists($username.'/'.trim(explode('-', $_POST['sender'])[0]), 'account')) {redirect('../bank', 'konto finns inte');}
    if (isset($_POST['account-number']) and $_POST['reciever'] == 'other' and account_exists($_POST['account-number'], 'id')) {
      transfer(trim(explode('-', $_POST['sender'])[0]), get_account_from_id($_POST['account-number']), $_POST['amount']);
    } else if ($_POST['reciever'] != 'other' and account_exists($username.'/'.trim(explode('-', $_POST['reciever'])[0]), 'account')) {
      transfer(trim(explode('-', $_POST['sender'])[0]), trim(explode('-', $_POST['reciever'])[0]), $_POST['amount']);
    } else {
      redirect('../bank', 'kontot finns inte');
    }
  }
 ?>

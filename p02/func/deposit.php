<?php
  require_once("../func/db_connect.php");
  require_once("../func/get_user_id.php");
  require_once("../func/sql_protection.php");


  function deposit ($account, $amount, $pdo) {
    session_start();

    if (!isset($_SESSION['login_key'])) {
      header("Location: ../");
      return;
    }
    if (sql_protection($account.$recipient.$recipient_account_id.$amount)) {
      header("Location: ../user/account.php?account=".$account."&mess=Innehåller förbjudna tecken");
      return;
    }

    if ($amount <= 0) {
      header("Location: ../user/account.php?account=".$account."&mess=Ogiltlig summa");
      return;
    }

    $info = "insättning";

    $transaction_date = date("Y-m-d-H:i");

    $sql = "INSERT INTO transactions (account_id, info, amount, transaction_date) VALUES (:account, :info, :amount, :transaction_date)";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('account' => $account, 'info' => $info, 'amount' => $amount, 'transaction_date' => $transaction_date));
    $res = $stm->fetch(PDO::FETCH_ASSOC);


    header("Location: ../user/account.php?account=".$account."&mess=insättningen gick igenom");
  }

  if (isset($_POST['account'])) {
    deposit($_POST['account'], $_POST['amount'], $pdo);
  }
 ?>

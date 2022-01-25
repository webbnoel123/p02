<?php
  require_once("../func/db_connect.php");
  require_once("../func/get_user_id.php");
  require_once("../func/sql_protection.php");
  require_once("../func/get_accounts.php");
  require_once("../func/get_account_name.php");
  require_once("../func/get_transactions.php");
  require_once("../func/get_balance.php");


  function make_transaction ($account, $recipient, $recipient_account_id, $amount, $pdo) {
    session_start();

    if (!isset($_SESSION['login_key'])) {
      header("Location: ../");
      return;
    }
    if (sql_protection($account.$recipient.$recipient_account_id.$amount)) {
      header("Location: ../user/account.php?account=".$account."&mess=Innehåller förbjudna tecken");
      return;
    } #skydd mot sql-injection
    if (!empty($recipient) and empty(get_accounts(get_user_id($recipient, $pdo), $pdo))) {
      header("Location: ../user/account.php?account=".$account."&mess=Ogiltlig användare");
      return;
    } #kollar vilket konto pengarna ska in på om det är en annan användare
    if ($amount <= 0) {
      header("Location: ../user/account.php?account=".$account."&mess=Ogiltlig summa");
      return;
    } #kollar ogiltligt belopp
    if ($amount > get_balance($account, $pdo)) {
      header("Location: ../user/account.php?account=".$account."&mess=Du har inte tillräckligt med pengar");
      return;
    } #kollar om användaren har tillräckligt med pengar
    if (empty($recipient)) {
      $info = "överföring till kontot ".get_account_name($recipient_account_id, $pdo);
    } else {
      $info = "överföring till ".$recipient;
    } #kollar om det är till en annan användare

    $transaction_date = date("Y-m-d-H:i");

    #skapar transaktionen för användaren
    $sql = "INSERT INTO transactions (account_id, info, amount, transaction_date) VALUES (:account, :info, :amount, :transaction_date)";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('account' => $account, 'info' => $info, 'amount' => "-".$amount, 'transaction_date' => $transaction_date));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    $info = "överföring från ".get_account_name($account, $pdo);

    if (!empty($recipient)) {
      $recipient_account_id = get_accounts(get_user_id($recipient, $pdo), $pdo)[0]['account_id'];
    }

    #skapar transaktionen för mottagaren
    $sql = "INSERT INTO transactions (account_id, info, amount, transaction_date) VALUES (:recipient, :info, :amount, :transaction_date)";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('recipient' => $recipient_account_id, 'info' => $info, 'amount' => $amount, 'transaction_date' => $transaction_date));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    header("Location: ../user/account.php?account=".$account."&mess=transaktionen gick igenom");
  }

  if (isset($_POST['account'])) {
    if (isset($_POST['recipient_account_id'])) {
      make_transaction($_POST['account'], "", $_POST['recipient_account_id'], $_POST['amount'], $pdo);
    } else {
      make_transaction($_POST['account'], $_POST['recipient'], "", $_POST['amount'], $pdo);
    }

  }
 ?>

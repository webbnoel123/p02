<?php
  require_once("../func/db_connect.php");
  require_once("../func/get_user_id.php");
  require_once("../func/sql_protection.php");


  function insert_account ($account_name, $pdo) {
    session_start();

    if (!isset($_SESSION['login_key'])) {
      header("Location: ../");
    }

    if (isset($_POST['account_name'])) {
      if (sql_protection($_POST['account_name'])) {
        header("Location: ../user/create_account.php?mess=Innehåller förbjudna tecken");
      }
      $sql = "INSERT INTO accounts (user_id, account_name) VALUES (:user_id, :account_name)";
      $stm = $pdo->prepare($sql);
      $stm->execute(array('user_id' => get_user_id($_SESSION['login_key'], $pdo), 'account_name' => $account_name));
      $res = $stm->fetch(PDO::FETCH_ASSOC);
    }
    header("Location: ../user/index.php?mess=Kontot har skapats");
  }

  if (isset($_POST['account_name'])) {
    insert_account($_POST['account_name'], $pdo);
  }
 ?>

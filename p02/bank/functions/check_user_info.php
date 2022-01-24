<?php
  require_once("db_connect.php");
  require_once("encrypt_password.php");

  function check_user_info($username, $password) {
    if (substr_count($_SESSION['username'], '=') or substr_count($_SESSION['username'], '"') or substr_count($_SESSION['username'], "'")) {
      redirect('../');
    }

    $sql = "SELECT * FROM user_info WHERE username = :username";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('username' => $username));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    $password = encrypt_password($password, $res['firstname'], $res['lastname']);

    if ($password != $res['password']) {
      redirect("../index.php?mess=fel inloggningsuppgifter");
    }
  }

 ?>

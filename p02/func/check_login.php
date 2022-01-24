<?php
  require_once("../func/check_login_key.php");
  require_once("../func/encrypt_password.php");

  $login_key = $_SESSION['login_key'];
  $password = $_SESSION['password'];

  if (substr_count($_SESSION['login_key'], '=') or substr_count($_SESSION['login_key'], "'") or substr_count($_SESSION['login_key'], '"')) {
    header('Location: ../');
  } #skyddar mot sql injection


  $sql = "SELECT * FROM user_info WHERE username = :username";
  $stm = $pdo->prepare($sql);
  $stm->execute(array('username' => $login_key));
  $res = $stm->fetch(PDO::FETCH_ASSOC);

  #krypterar lösenordet för att kolla om det matchar det lösenord vi lagrat i user_info
  $password = encrypt_password($password, $res['firstname'], $res['lastname']);

  if ($password != $res['password']) {
    header("Location: ../index.php?mess=fel inloggningsuppgifter");
  }

 ?>

<?php
  require_once("check_login_key.php");
  function get_user_id($login_key, $pdo) {
    if (check_login_key($login_key)) {
      $sql = "SELECT * FROM user_info WHERE email = :email";
      $stm = $pdo->prepare($sql);
      $stm->execute(array('email' => $login_key));
    } #kollar om det är email användaren loggar in med
    else {
      $sql = "SELECT * FROM user_info WHERE username = :username";
      $stm = $pdo->prepare($sql);
      $stm->execute(array('username' => $login_key));
    } #annars är det användarnamn
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    return $res["user_id"];
  }


 ?>

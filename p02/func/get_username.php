<?php
  function get_username($login_key) {
    if (check_user($login_key)) {
      $sql = "SELECT username FROM user_info WHERE email = :email";
      $stm = $pdo->prepare($sql);
      $stm->execute(array('email' => $login_key));
      $res = $stm->fetchAll(PDO::FETCH_ASSOC);

      return $res[0]["username"];
    } else {
      return $login_key;
    }
  }

 ?>

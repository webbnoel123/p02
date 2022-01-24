<?php
  function get_accounts($user_id, $pdo) {
    $sql = "SELECT * FROM accounts WHERE user_id = :user_id";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('user_id' => $user_id));
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $res;
  } #returnerar en lista på alla konton user_id
 ?>

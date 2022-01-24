<?php
  function get_account_name($account_id, $pdo) {
    $sql = "SELECT account_name FROM accounts WHERE account_id = :account_id";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('account_id' => $account_id));
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $res[0]["account_name"];
  }
 ?>

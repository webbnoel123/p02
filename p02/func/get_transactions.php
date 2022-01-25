<?php
  function get_transactions($account_id, $pdo) {
    $sql = "SELECT * FROM transactions WHERE account_id = :account_id";
    $stm = $pdo->prepare($sql);
    $stm->execute(array('account_id' => $account_id));
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);

    return array_reverse($res);
  } #returnerar en lista på alla transaktioner account_id
 ?>

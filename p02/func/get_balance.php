<?php
  function get_balance($account_id, $pdo) {
    $transactions = [];
    foreach(get_transactions($account_id, $pdo) as $transaction) {
      if ($account_id == $transaction["account_id"]) {
        array_push($transactions, (int)$transaction['amount']);
      }
    }
    return array_sum($transactions);
  }
 ?>

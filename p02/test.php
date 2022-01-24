<?php
include("func/get_transactions.php");
include("func/db_connect.php");

$transactions = get_transactions(1, $pdo);
print_r($transactions);
 ?>

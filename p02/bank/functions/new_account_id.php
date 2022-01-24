<?php
  function new_account_id($user, $account) {
    $legal_characters = "abcdefghijklmnopqrstuvwxyz1234567890,.-;:_";
    $account_id = "";

    foreach (str_split($user) as $char) {
      $add = strval(strpos($legal_characters, $char));
      if (strlen($add) == 1) {
        $account_id .= strval(strpos($legal_characters, $char)).'-';
      } else {
        $account_id .= strval(strpos($legal_characters, $char));
      }
    }
    foreach (str_split($account) as $char) {
      $add = strval(strpos($legal_characters, $char));
      if (strlen($add) == 1) {
        $account_id .= strval(strpos($legal_characters, $char)).'-';
      } else {
        $account_id .= strval(strpos($legal_characters, $char));
      }
    }
    return $account_id;
  }
  echo new_account_id('noel', 'main');
 ?>

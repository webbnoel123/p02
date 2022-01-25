<?php
  function get_account_balance($username, $account, $path=NULL) {
    if ($path != NULL) {
      $transactions = array_slice(file($path.'/'.$username.'/'.$account.'.txt', FILE_IGNORE_NEW_LINES), 1);
    } else {
      $transactions = array_slice(file('../user_info/'.$username.'/'.$account.'.txt', FILE_IGNORE_NEW_LINES), 1);
    }
    $account_balance = 0;
    foreach ($transactions as $transaction) {
      if (!empty($transaction)) {
        $account_balance += (float)explode('|', $transaction)[0];
      }
    }
    return $account_balance;
  }

  function get_account_id($username, $account) {
    return explode('|', file('../user_info/'.$username.'/'.$account.'.txt', FILE_IGNORE_NEW_LINES)[0])[1];
  }

  function account_exists($id, $type=NULL) {
    if ($type == NULL or $type == 'id') {
      return file_exists('../user_info/'.get_account_from_id($id).'.txt');
    } else {
      return file_exists('../user_info/'.$id.'.txt');
    }
  }

  function check_legal_account_name($name) {
    $legal_characters = "abcdefghijklmnopqrstuvwxyz ";
    if (strlen($name) > 8) { return -1; }
    if (strlen($name) < 1) { return 0; }
    foreach (str_split($name) as $char) {
      if (!str_contains($legal_characters, $char)) { return 0; }
    }
    return 1;
  }


  function get_accounts_by_user($username) {
    $accounts = [];
    foreach (array_slice(scandir('../user_info/'.$username), 2) as $account) {
      array_push($accounts, substr($account, 0, -4));
    }
    return $accounts;

  }

  function get_account_transactions($username, $account) {
    $transactions = array_reverse(array_slice(file('../user_info/'.$username.'/'.$account.'.txt', FILE_IGNORE_NEW_LINES), 1));
    $processed_transactions = [];
    foreach ($transactions as $transaction) {
      if (!empty($transaction)) {
        $transaction = explode('|', $transaction);
        $processed_transaction = ['amount' => $transaction[0],
                                  'reciever' => $transaction[1],
                                  'date' => $transaction[2]];
        array_push($processed_transactions, $processed_transaction);
      }
    }
    return $processed_transactions;
  }

  function new_account_id($username, $account) {
    $legal_characters = "abcdefghijklmnopqrstuvwxyz";
    if ($account != 'main') {
      $account = $username .','. $account;
    } else {
      $account = $username;
    }

    $account_id = "";

    foreach (str_split($account) as $char) {
      if ($char == ',') {
        $account_id .= ', ';
        continue;
      }
      $add = strval(strpos($legal_characters, $char));
      if (strlen($add) == 1) {
        $account_id .= strval(strpos($legal_characters, $char)).'-';
      } else {
        $account_id .= strval(strpos($legal_characters, $char));
      }
    }
    return $account_id;
  }

  function get_account_from_id($id) {
    $alphabet = "abcdefghijklmnopqrstuvwxyz";
    $username = '';
    $account_name = '';
    if (str_contains($id, ',')) {
      $user = str_split(explode(', ', $id)[0], 2);
      $account = str_split(explode(', ', $id)[1], 2);
    } else {
      $user = str_split($id, 2);
      $account_name = 'main';
    }

    foreach ($user as $letter) {
      if (str_contains($letter, '-')) {
        $letter = substr($letter, 0, -1);
      }
      $index = (int)$letter;
      $username .= substr($alphabet, $index, 1);
    }
    if (empty($account_name)) {
      foreach ($account as $letter) {
        if (str_contains($letter, '-')) {
          $letter = substr($letter, 0, -1);
        }
        $index = (int)$letter;
        $account_name .= substr($alphabet, $index, 1);
      }
    }

    return $username.'/'.$account_name;
  }

 ?>

<?php
  function get_legal_username($username) {
    if (strlen($username) < 4) {
      return 'username must be atleast 4 characters';
    }
    if (str_contains($username, '|') or str_contains($username, ' ')) {
      return 'username can not contain "|" or " "';
    }
    return 'legal';
  }

  function get_legal_password($password) {
    if (strlen($password) < 5) {
      return 'password must be atleast 5 characters';
    }
    if (str_contains($password, '|') or str_contains($password, ' ')) {
      return 'password can not contain "|" or " "';
    }
    return 'legal';
  }

  function user_exists($user) {
    return file_exists('../../user_info/'.$user);
  }
 ?>

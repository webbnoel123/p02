<?php
  function check_login_key($login_key) {
    return substr_count($login_key, '@');
  } #kollar om användaren har loggat in med email eller personnummer, 0 = användarnamn, 1 = email
 ?>

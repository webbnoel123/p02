<?php
  function encrypt_password($password, $salt_before, $salt_after) {
    return sha1($salt_before.$password.$salt_after);
  } #saltar före och efter lösenordet och krypterar sedan med sha1
 ?>

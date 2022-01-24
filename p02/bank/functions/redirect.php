<?php
  function redirect($url, $mess='') {
    ob_start();
    if (!$mess) {
      header('Location: '.$url);
    } else {
      header('Location: '.$url.'?mess='.$mess);
    }
    ob_end_flush();
    die();
  }
 ?>

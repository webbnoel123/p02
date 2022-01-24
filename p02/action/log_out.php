<?php
  include('redirect.php');
  session_start();
  session_unset();
  session_destroy();
  header('location: ../?mess=du har loggat ut');

 ?>

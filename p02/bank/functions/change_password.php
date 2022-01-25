<?php
  session_start();
  if (!isset($_SESSION['username']) or !file_exists('../../user_info/'.$_SESSION['username'].'/main.txt')) {
    redirect('../');
  }

  include('redirect.php');
  include('get_user_info.php');

  $file_name = '../../user_info/'.$_SESSION['username'].'/main.txt';
  $file_content = file_get_contents($file_name);
  if (!password_verify($_POST['old_password'], explode('|', $file_content, 2)[0])) {
    redirect('../', 'fel lösenord');
  }
  if ($_POST['new_password'] != $_POST['repeat_password']) {
    redirect('../', 'lösenorden stämmer inte');
  }
  if (get_legal_password($_POST['new_password']) != 'legal') {
    redirect('../', get_legal_password($_POST['password']));
  }

  $file_content = explode('|', $file_content, 2)[1];
  $file_content = password_hash($_POST['new_password'], PASSWORD_DEFAULT).'|'.$file_content;

  $file = fopen($file_name, 'w');
  fwrite($file, $file_content);
  fclose($file);
  $_SESSION['password'] = $_POST['new_password'];
  redirect('../', 'lösenordet byttes');
 ?>

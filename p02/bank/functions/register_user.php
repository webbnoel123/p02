<?php
  include('redirect.php');
  include('get_user_info.php');
  include('get_account_info.php');
  if (isset($_POST['username'])) {
    if (user_exists($_POST['username'])) {
      redirect('../../register.php', 'användare finns redan');
    }
    if (get_legal_username($_POST['username']) != 'legal') {
      rredirect('../../register.php', get_legal_username($_POST['username']));
    }
    if (get_legal_password($_POST['password']) != 'legal') {
      redirect('../../register.php', get_legal_password($_POST['password']));
    }
    if ($_POST['password'] != $_POST['repeat_password']) {
      redirect('../../register.php', 'passwords do not match');
    }

    mkdir('../../user_info/'.$_POST['username']);
    $file = fopen('../../user_info/'.$_POST['username'].'/main.txt', 'w');
    fwrite($file, password_hash($_POST['password'], PASSWORD_DEFAULT).'|'.new_account_id($_POST['username'], 'main'));
    fclose($file);

    session_start();

    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    redirect('../');
  } else {
    redirect('../../');
  }
 ?>

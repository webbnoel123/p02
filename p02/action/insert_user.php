<?php
  require_once("../func/db_connect.php");
  require("../func/encrypt_password.php");
  require_once("../func/sql_protection.php");

  #skapar variabler som vi ska skicka in i user_info tabellen i databasen

  session_start();
  $_SESSION['login_key'] = $_POST['username'];
  $_SESSION['password'] = $_POST['password'];

  $username = $_POST['username'];

  $firstname = $_POST['firstname'];
  if (preg_replace("/[^A-Öa-ö ]/", '', $firstname) != $firstname) {
    header('Location: register.php?mess=inkorrekt förnamn');
  } #kollar om förnamn är inkorrekt genom att den inte innehåller något annat än bokstäver

  $lastname = $_POST['lastname'];
  if (preg_replace("/[^A-Öa-ö ]/", '', $lastname) != $lastname) {
    header('Location: register.php?mess=inkorrekt efternamn');
  } #kollar om efternamn är inkorrekt genom att den inte innehåller något annat än bokstäver

  #krypterar lösenord med salt och sha1
  $password = encrypt_password($_POST['password'], $firstname, $lastname);

  $active = 1;

  #skyddar för sql injection
  if (sql_protection($username.$firstname.$_POST['password'].$lastname)) {
    header("location: ../?mess=ogiltlig inmatning");
  }

  $sql = "SELECT * FROM user_info WHERE username = :username";
  $stm = $pdo->prepare($sql);
  $stm->execute(array('username' => $username));
  $res = $stm->fetchAll(PDO::FETCH_ASSOC);

  if (count($res) != 0) {
    header("Location: admin.php?mess=användarnamn upptaget");
  } #kollar så att det inte finns ett konto med samma username

  #skapar en ny användare i tabellen user_info
  $sql = "INSERT INTO user_info (username, password, firstname, lastname, active) VALUES (:username, :password, :firstname, :lastname, :active)";
  $stm = $pdo->prepare($sql);
  $stm->execute(array('username' => $username, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'active' => $active));

  header("location:../user");
 ?>

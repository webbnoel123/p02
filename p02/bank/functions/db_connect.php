<?php
  # Variabler
  if (strcmp($_SERVER['SERVER_NAME'], "localhost") == 0) {
    $host = "localhost";      // Den server där databasen ligger
    $user = "root";           // Ditt användarnamn
    $pwd  = "root";           // Ditt lösenord
    $db   = "slutprojekt";           // Databasen vi vill jobba mot
  } else {
    $host = "server1.serverdrift.com";      // Den server där databasen ligger
    $user = "alstromh_030806nt";           // Ditt användarnamn
    $pwd  = "W+#xiVoCyXhZ";           // Ditt lösenord
    $db   = "alstromh_030806nt";           // Databasen vi vill jobba mot
  }


  # dsn - data source name
  $dsn = "mysql:host=$host;dbname=$db";
  # Inställningar som körs när objektet skapas
  $options  = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
    PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES, false);
  # Skapa objektet eller kasta ett fel
  try {
    $pdo = new PDO($dsn, $user, $pwd, $options);
  }
  catch(Exception $e) {
      die('Could not connect to the database:<br/>'.$e);
  }
?>

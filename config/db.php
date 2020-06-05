<?php
//Säkerställer att fel visas under utvecklingsskedet
//OBS! Ta bort innan webbsidan går live
ini_set('display_errors', '1');
error_reporting(E_ALL);


//Uppgifter om databasen
$db_server = "localhost"; //mysql:host (se new PDO i try-catch-satsen) är nästan alltid localhost (90% av fallen)
$db_database = "webshop";
$db_username = "root";
$db_password = "root";
//OBS! $db_password för XAMPP = "", $db_password för MAMP = "root"


//Skapar ny uppkoppling mot databasen
try {
  $db = new PDO("mysql:host=$db_server;dbname=$db_database;charset=utf8", $db_username, $db_password);

  //Aktiverar hantering av felmeddelanden
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Förhindrar PDO att använda simulerade förfrågningar
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  //Visar felmeddelande om uppkopplingen misslyckas
} catch (PDOException $e) {
  echo "<h2>Error: " . $e->getMessage() . "</h2>";
}

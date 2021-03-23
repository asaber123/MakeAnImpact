<?php
// Made by Åsa Berglund 2021

if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
//Variable for title on he page
$site_title = "IMPACT";
$divider = " | ";

function __autoload($class_name)
{
    include 'classes/' . $class_name . '.class.php';
}
//Check if its runned on local or public host
$devmode = false;
if ($devmode) {
    error_reporting(-1);
    ini_set("display_errors", 1);

    //DB settings localhost
    define("DBHOST", "localhost");
    define("DBUSER", "impact");
    define("DBPASS", "livetpaenpinne2021");
    define("DBDATABASE", "impact");
} else {
    //DB settings mysql simply.com
    define("DBHOST", "mysql112.unoeuro.com");
    define("DBUSER", "asaberglund_se");
    define("DBPASS", "livetpaenpinne2021");
    define("DBDATABASE", "asaberglund_se_db");
}

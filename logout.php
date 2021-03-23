<?php
// Made by Åsa Berglund 2021

if(!isset($_SESSION['username'])){
session_start();}
session_destroy();

header("Location: index.php");
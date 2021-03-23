<?php
//Made by Åsa Berglund2021
//Create DB using PHP, to install tables go to install.php

include('includes/config.php');

//Connect to DB
$db=new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die("Fel vid anlutning:" . $this->db->connect_error);
}

$sql ="DROP TABLE IF EXISTS UsersImpact;";
$sql .= "CREATE TABLE UsersImpact(
    user_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    signupdate timestamp NOT NULL DEFAULT current_timestamp()
);";

/* SQL code to create table */
$sql .= "DROP TABLE IF EXISTS PostsImpact;";
$sql .= "CREATE TABLE PostsImpact(
    post_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(64) NOT NULL,
    content TEXT NOT NULL,
    postDate timestamp NOT NULL DEFAULT current_timestamp(),
    filename VARCHAR (100),
    category VARCHAR (60),
    postedBy VARCHAR(100)
);";

/* If success, print print pre tag else warning */
if($db->multi_query($sql)) {
    echo "Table installed";
    echo "<pre> $sql </pre>";
} else {
    echo "Something happend, tables in not installed!";
}




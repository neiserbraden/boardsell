<?php
$host="localhost";$dbname="boardsell";$user="root";$pass="";
$pdo=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$user,$pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
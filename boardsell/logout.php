<?php
require_once __DIR__ . "/lib/auth.php";
require_user();

session_destroy();
header("Location: login.php");
exit;

session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit;

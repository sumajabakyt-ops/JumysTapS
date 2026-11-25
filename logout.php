<?php

require_once 'db.php';

// Сессиядағы мәліметтерді тазарту
$_SESSION = [];

// Сессияны жою
session_destroy();

// Басты бетке қайтару
header("Location: index.php");
exit;

?>

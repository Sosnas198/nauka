<?php
// UNIWERSALNY WZORZEC: Nawiązanie i zamknięcie połączenia z MySQLi

$host = "localhost";
$user = "root";
$pass = "";
$db   = "kino";

// 1. Otwarcie połączenia
$conn = new mysqli($host, $user, $pass, $db);

// Miejsce na kod strony / zapytania SQL...

// 2. Zamknięcie połączenia na końcu skryptu
$conn->close();
?>
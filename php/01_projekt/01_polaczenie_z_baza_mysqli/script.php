<?php
// UNIWERSALNY WZORZEC: Nawiązanie i zamknięcie połączenia z MySQLi
// -----------------------------------------------------------------------------

// --- KROK 1: Definicja parametrów dostępowych ---
// [ZOBACZ W README: SEC-1]
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kino";

// --- KROK 2: Otwarcie połączenia z bazą MySQL ---
// [ZOBACZ W README: SEC-2]
$conn = new mysqli($host, $user, $pass, $db);

// --- KROK 3: Sprawdzenie czy połączenie się udało ---
// [ZOBACZ W README: SEC-3]
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// --- KROK 4: Miejsce na kod strony, wykonywanie zapytań SQL ($conn->query) ---
// [ZOBACZ W README: SEC-4]
// ...

// --- KROK 5: Zamknięcie połączenia na końcu skryptu ---
// [ZOBACZ W README: SEC-5]
$conn->close();

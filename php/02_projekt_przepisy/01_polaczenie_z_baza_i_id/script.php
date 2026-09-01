<?php
// UNIWERSALNY WZORZEC: Połączenie z bazą przepisy i inicjacja zmiennej ID
// -----------------------------------------------------------------------------

// --- KROK 1: Definicja parametrów dostępowych (arkusz: localhost, root, bez hasła, baza przepisy) ---
// [ZOBACZ W README: SEC-1]
$host = "localhost";
$user = "root";
$pass = "";
$db   = "przepisy";

// --- KROK 2: Otwarcie połączenia z bazą MySQL ---
// [ZOBACZ W README: SEC-2]
$conn = new mysqli($host, $user, $pass, $db);

// --- KROK 3: Sprawdzenie czy połączenie się udało ---
// [ZOBACZ W README: SEC-3]
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// --- KROK 4: Inicjacja zmiennej ID — GET albo wartość 7 ---
// [ZOBACZ W README: SEC-4]
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = 7;
}

// --- KROK 5: Miejsce na skrypty 1–4 ($conn->query, użycie $id) ---
// [ZOBACZ W README: SEC-5]
// ...

// --- KROK 6: Zamknięcie połączenia na końcu skryptu ---
// [ZOBACZ W README: SEC-5]
$conn->close();

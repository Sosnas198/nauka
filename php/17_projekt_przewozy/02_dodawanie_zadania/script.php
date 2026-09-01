<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — dodawanie zadania z formularza (INSERT)
// -----------------------------------------------------------------------------

// --- KROK 1: Odczyt danych z formularza ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zadanie = trim($_POST['zadanie'] ?? '');
    $data = $_POST['data'] ?? '';
    if ($zadanie !== '' && $data !== '') {

        // --- KROK 2: Zapytanie 2 zmodyfikowane — INSERT ---
        // [ZOBACZ W README: SEC-2]
        if (!$mysqli->connect_errno) {
            $stmt = $mysqli->prepare('INSERT INTO zadania VALUES (NULL, ?, ?, 1)');
            $stmt->bind_param('ss', $zadanie, $data);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            header('Location: przewozy.php');
            exit;
        }
    }
}

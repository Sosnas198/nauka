<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — tabela zadań i usuwanie przez $_GET['usun']
// -----------------------------------------------------------------------------

// --- KROK 1: Usuwanie zadania (zapytanie 3 zmodyfikowane) ---
// [ZOBACZ W README: SEC-1]
if (isset($_GET['usun'])) {
    $stmt = $mysqli->prepare('DELETE FROM zadania WHERE id_zadania = ?');
    $stmt->bind_param('i', $_GET['usun']);
    $stmt->execute();
    $stmt->close();
    header('Location: przewozy.php');
    exit;
}

// --- KROK 2: Zapytanie 1 — lista zadań ---
// [ZOBACZ W README: SEC-2]
$result = $mysqli->query('SELECT id_zadania, zadanie, data FROM zadania');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['zadanie'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($row['data'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td><a href="?usun=' . (int)$row['id_zadania'] . '">Usuń</a></td>';
        echo '</tr>';
    }
    $result->free();
}

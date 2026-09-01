<?php
    // Skrypt #4
    if (isset($_POST['dodaj'])) {
        $nazwa = trim($_POST['nazwa'] ?? '');
        $opis = trim($_POST['opis'] ?? '');
        $cena = trim($_POST['cena'] ?? '0');
        $zdjecie = trim($_POST['zdjecie'] ?? '');

        $stmt = $conn->prepare("INSERT INTO gry (nazwa, opis, punkty, cena, zdjecie) VALUES (?, ?, 0, ?, ?)");
        $stmt->bind_param("ssss", $nazwa, $opis, $cena, $zdjecie);
        $stmt->execute();
        $stmt->close();
    }
?>

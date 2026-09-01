<?php
    // Skrypt #3
    if (isset($_POST['pokazopis'])) {
        $id = $_POST['inputopis'];
        if ($id !== false && $id !== null) {
            $stmt = $conn->prepare("SELECT nazwa, LEFT(opis, 100) AS opis, punkty, cena FROM gry WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                echo "<h2>" . htmlspecialchars($row["nazwa"]) . ", " . (int)$row["punkty"] . " punktów, " . htmlspecialchars($row["cena"]) . " zł</h2>";
                echo "<p>" . htmlspecialchars($row["opis"]) . "</p>";
            } else {
                echo "<p>Nie znaleziono gry.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Podaj poprawne ID.</p>";
        }
    }
?>

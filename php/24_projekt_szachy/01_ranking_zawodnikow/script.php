<?php
    // Skrypt #1
    $sql = "SELECT pseudonim, tytul, ranking, klasa FROM zawodnicy WHERE ranking > 2787 ORDER BY ranking DESC;";
    $result = $conn->query($sql);
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row["pseudonim"] . "</td>";
        echo "<td>" . $row["tytul"] . "</td>";
        echo "<td>" . $row["ranking"] . "</td>";
        echo "<td>" . $row["klasa"] . "</td>";
        echo "</tr>";
        $i++;
    }
    echo "<tr>";
    echo "</tr>";
?>
